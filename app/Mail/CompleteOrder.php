<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompleteOrder extends Mailable {

  use Queueable, SerializesModels;
  
  public $clientName;
  public $status;
  public $url;
  public $prodName;
  /**
  * Create a new message instance.
  */
  public function __construct($clientName, $status, $prodName, $url) {
      $this->clientName = $clientName;
      $this->status = $status;
      $this->prodName = $prodName;
      $this->url = $url;
  }

  
  /**
  * Get the message envelope.
  */
  public function build(): Envelope {
    return new Envelope(
      subject: 'Your order is complete!'
    );
  }
  
  /**
  * Get the message content definition.
  */
  public function content(): Content {
    return new Content(
      markdown: 'emails.complete-order',
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
