<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DenyOrder extends Mailable {

  use Queueable, SerializesModels;
  
  public $clientName; 
  public $status; 
  public $prodName;
  public $url;
  public $reason;
  
  /**
  * Create a new message instance.
  */
  public function __construct($clientName, $status, $prodName, $url, $reason) {
    $this->clientName = $clientName;
    $this->status = $status;
    $this->prodName = $prodName;
    $this->url = $url;
    $this->reason = $reason;
  }
  
  /**
  * Get the message envelope.
  */
  public function build(): Envelope {
    return new Envelope(
      subject: 'Your order has been denied!'
    );
  }
  
  /**
  * Get the message content definition.
  */
  public function content(): Content {
    return new Content(
      markdown: 'emails.deny-order',
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
