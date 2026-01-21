<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendForm;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
class TicketController extends Controller
{
    private $client;
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
            'message'=>'required|string|max:1000' 
           // 'attachment'=>'file|max:10240' // max 10MB 
            ]);
        $request->session()->put('formdata', $formdata);
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
        
        if(!$request->has('code')){
            return redirect()->route('supportform')->with('error','Authorization code is missing. Please try again.');
        }
        $token=$this->client->fetchAccessTokenWithAuthCode($request->input('code'));
        $this->client->setAccessToken($token);

        $to=['akashtester15@gmail.com']; //Which address to send the mail
        $subject='New Support Ticket From: '.$data['name'];
        $messagebody='A new ticket has been raised!<br/>';

        $message=new Message();

        $rawmessagestring= "From: Support Ticket\r\n";
        $rawmessagestring= "To: ".implode(",",$to)."\r\n";
        $rawmessagestring.= "Subject: ".$subject."\r\n";
        $rawmessagestring.= "MIME-Version: 1.0\r\n";
        $rawmessagestring.= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $rawmessagestring.= "<p>".$messagebody."</p><br/>";
        $rawmessagestring.= "Name: ".$data['name']."<br/>";
        $rawmessagestring.= "E-Mail: ".$data['email']."<br/>";
        $rawmessagestring.= "Phone: ".$data['phone']."<br/>";
        $rawmessagestring.= "Message: ".$data['message']."<br/>";

        // $message->setraw($rawmessagestring);
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

        $rawmessage=base64_encode($rawmessagestring);
        $rawmessage=str_replace(['+','/','='],['-','_',''], $rawmessage);
        $message->setRaw($rawmessage);

        $gmail=new Gmail($this->client);
        try{
            $gmail->users_messages->send('me',$message);
            return view('thanks');
        }catch(\Exception $e){
            return 'Failed to send email: '.$e->getMessage();
        }
        //return redirect()->route('thanks');
        
    }

}
