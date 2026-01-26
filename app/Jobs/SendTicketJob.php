<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class SendTicketJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $to;
    protected $subject;
    protected $messagetext;
    /**
     * Create a new job instance.
     */
    public function __construct($to, $subject, $messagetext)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->messagetext = $messagetext;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        // $client->setAccessToken("YOUR_ACCESS_TOKEN_HERE");

        // Here you would typically set the access token, possibly from a stored location
        // $client->setAccessToken($accessToken);

        $gmail = new Gmail($client);

        $rawMessage = "To: " . $this->to . "\r\n";
        $rawMessage .= "Subject: " . $this->subject . "\r\n";
        $rawMessage .= "MIME-Version: 1.0\r\n";
        $rawMessage .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $rawMessage .= $this->messagetext;

        $encodedMessage = base64_encode($rawMessage);
        $encodedMessage = str_replace(['+', '/', '='], ['-', '_', ''], $encodedMessage);

        $message = new Message();
        $message->setRaw($encodedMessage);

        try {
            $gmail->users_messages->send('me', $message);
        } catch (\Exception $e) {
            // Handle error
            \Log::error('Error sending email: ' . $e->getMessage());
        }
    }
}
