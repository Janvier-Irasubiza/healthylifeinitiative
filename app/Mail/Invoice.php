<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Invoice extends Mailable {

  use Queueable, SerializesModels;
  
    public $orderInfo;
    public $products;
    public $client; 
    public $totalDue;
  
  /**
  * Create a new message instance.
  */
  public function __construct($orderInfo, $products, $client, $totalDue) {
    $this->url = $orderInfo;
    $this->url = $products;
    $this->url = $client;
    $this->client = $totalDue;
  }
  
  /**
  * Get the message envelope.
  */
  public function build(): Envelope {
    return new Envelope(
      subject: 'Invoice for your order'
    );
  }
  
  /**
  * Get the message content definition.
  */
  public function content(): Content {
    return new Content(
      markdown: 'payment',
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
