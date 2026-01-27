<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Notifications\SendForm;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class TicketController extends Controller
{
    private $client;
    public $filename;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $this->client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $this->client->addScope(Gmail::GMAIL_SEND);
        //$this->client->setAccessType('offline');
        //$this->client->setPrompt('select_account consent');
    }
    // Call the methods referenced in web routes
    public function supportform()
    {
        return view('supportform');
    }

    public function getFormData(Request $request)
    {
        $formdata = $request->validate([
            'name'=>'required|string|max:100',
            'email'=>'required|string|max:100',
            'phone'=>'required|string|max:100',
            'message'=>'required|string|max:1000',
            // 'attachment'=>'file|max:10240' // max 10MB 
            ]);
        $request->validate(['attachment'=>'file|max:10240']); // max 10MB
    if($request->hasFile('attachment')){
        $this->filename = 'example.'. $request->file('attachment')->extension();   
        $request->file('attachment')->move(public_path('attachments'), $this->filename);  
        $request->session()->put('filename', $this->filename);      
    }
        $request->session()->put('formdata', $formdata);

        // Push the validated data to the database
        if($request->submit){
            $ticket = new Ticket();
            $ticket->name = $formdata['name'];
            $ticket->email = $formdata['email'];
            $ticket->phone = $formdata['phone'];
            $ticket->message = $formdata['message'];
            if($this->filename){
                $ticket->attachment = $this->filename;
            }
            $ticket->save();
        }

        // Once posting is done, redirect to send email
        return redirect()->route('send.email');
    }
   
    public function sendEmail()
    {
                       
        $authUrl = $this->client->createAuthUrl();
        // Redirect the user to $authUrl and get the authorization code
        return redirect($authUrl);
    }

    
    
    public function thanks(Request $request)
    {
        $data = $request->session()->get('formdata'); 
        $this->filename = $request->session()->get('filename');

        $ticket = DB::table('collected_tickets')->latest('ticket_id')->first();
        
        if(!$request->has('code')){
            return redirect()->route('supportform')->with('error','Authorization code is missing. Please try again.');
        }
        $token=$this->client->fetchAccessTokenWithAuthCode($request->input('code'));
        $this->client->setAccessToken($token);

        $bcc=['akashtester15@gmail.com']; //Bcc to admin
        $to=[$data['email']]; //Form response to the user who raised the ticket
        $subject='New Support Ticket'.($ticket ? " #".$ticket->ticket_id : "").' From: '.$data['name'];
            
        // $messagetext.= "To: ".implode(",",$to)."\r\n";
        // $messagetext.= "Subject: ".$subject."\r\n";
        // $messagetext = "MIME-Version: 1.0\r\n";
        // $messagetext.= "Content-Type: text/html; charset: UTF-8\r\n\r\n";
        $messagetext = "<h1><p>A new ticket has been raised!</p></h1><br/>";
        $messagetext.= "Name: ".$data['name']."<br/>";
        $messagetext.= "E-Mail: ".$data['email']."<br/>";
        $messagetext.= "Phone: ".$data['phone']."<br/>";
        $messagetext.= "Message: ".$data['message']."<br/>";

        // Attachment handling
        if($this->filename){
        $filepath = ''.public_path('attachments/').$this->filename;
            $filedata = file_get_contents($filepath);
            $attachedname = basename($filepath);
           // $encodedfile = base64_encode($filedata);
         //   $filedata = str_replace(['+','/','='],['-','_',''], $filedata);
        }

        $boundary = uniqid(rand(), true);

        $messagebody = "--".$boundary."\r\n";
        $messagebody .= "Content-Type: text/html; charset: UTF-8\r\n";
        $messagebody .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
        $messagebody .= $messagetext . "\r\n";
        

        if($this->filename && file_exists($filepath)){
            $messagebody .= "--".$boundary."\r\n";
            $messagebody .= "Content-Type: application/txt; name={$attachedname}\r\n";
            $messagebody .= "Content-Disposition: attachment; filename={$attachedname}; filesize=".filesize($filepath)."\r\n\r\n";
           // $messagebody .= "Content-Transfer-Encoding: base64\r\n";
            $messagebody .= "{$filedata}.\r\n";
            $messagebody .= "--".$boundary."--";
        }

        $rawmessage = "From: Support Ticket\r\n";
        $rawmessage .= "To: ".implode(",",$to)."\r\n";
        $rawmessage .= "Bcc: ".implode(",",$bcc)."\r\n";
        $rawmessage .= "Subject: ".$subject."\r\n";
        $rawmessage .= "MIME-Version: 1.0\r\n";
        $rawmessage .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n\r\n";
        $rawmessage .= $messagebody;

        // $message->setraw($messagetext);
        /*try {
            if($request->hasFile('attachment')){
                $filename = time().'.'.$request->file('attachment')->extension();   
                $request->file('attachment')->move(public_path('attachments'), $filename);        
            }
        } catch (\Exception $e) {
            \Log::error('E-Mail send exception: '.$e->getMessage());
        }
        //dd($data);
        \Notification::route('mail', 'akashtester15@gmail.com')->notify(new SendForm($data));
        return redirect()->route('thanks');*/
        $message=new Message();
        $rawmessage=base64_encode($rawmessage);
        $rawmessage=str_replace(['+','/','='],['-','_',''], $rawmessage);
        $message->setRaw($rawmessage);

        $gmail=new Gmail($this->client);
        try{
            $gmail->users_messages->send('me',$message);

            // Reset session data after successful email send
            $request->session()->forget(['formdata', 'filename']);
            $this->filename = null;

            return view('thanks');
        }catch(\Exception $e){
            return 'Failed to send email: '.$e->getMessage();
        }
        //return redirect()->route('thanks');
        
    }

}
