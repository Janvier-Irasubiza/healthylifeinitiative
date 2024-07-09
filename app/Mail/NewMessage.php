<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMessage extends Mailable {

  use Queueable, SerializesModels;
  
  public $senderNames;
  public $message;
  public $replied;
  public $url;
  
  /**
  * Create a new message instance.
  */
  public function __construct($senderNames, $message, $replied, $url) {
    $this->senderNames = $senderNames;
    $this->message = $message;
    $this->replied = $replied;
    $this->url = $url;
  }
  
  /**
  * Get the message envelope.
  */
  public function build(): Envelope {
    return new Envelope(
      subject: 'You have received a new message.'
    );
  }
  
  /**
  * Get the message content definition.
  */
  public function content(): Content {
    return new Content(
      markdown: 'emails.message',
    );
  }
  
  /**
  * Get the attachments for the message.
  *
  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
  */
  public function attachments(): array {
    return [];
  }
  
}
