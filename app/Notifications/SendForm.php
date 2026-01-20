<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendForm extends Notification
{
    use Queueable;
    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data=$data;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('New Ticket from: '.$this->data['name'])
            ->line('A new ticket has been raised!')
            ->line('Name: '.$this->data['name'])
            ->line('E-Mail: '.$this->data['email'])
            ->line('Phone: '.$this->data['phone'])
            ->line('Message: '.$this->data['message']);

        // Attach the uploaded file if it exists
        if (!empty($this->data['attachment_path']) && file_exists($this->data['attachment_path'])) {
            $name = $this->data['attachment_name'] ?? basename($this->data['attachment_path']);
            $fileContent = file_get_contents($this->data['attachment_path']); //file_get_contents() reads the file content.
            $mail->attachData($fileContent, $name); //attachData() method stores the file name and content to $mail.
        }

        return $mail;
            //->action('Notification Action', url('/'))
            //->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
