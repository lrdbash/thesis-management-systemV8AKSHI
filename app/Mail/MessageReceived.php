<?php

// app/Mail/MessageReceived.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $receiver;
    public $sender;
    public $messageContent;

    public function __construct($receiver, $sender, $messageContent)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->view('emails.message_received')
                    ->subject('New Message from ' . $this->sender->name)
                    ->with([
                        'receiver' => $this->receiver,
                        'sender' => $this->sender,
                        'messageContent' => $this->messageContent,
                    ]);
    }
}
