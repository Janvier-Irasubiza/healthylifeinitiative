<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlacedOrder extends Mailable {

  use Queueable, SerializesModels;
  
  public $client;
  public $product;
  public $products;
  public $orderInfo;
  public $totalDue;
  public $qty;
  public $url;
  
  /**
  * Create a new message instance.
  */
  public function __construct(
    	$client, 
    	$product,
    	$products,
    	$orderInfo,
    	$totalDue,
    	$qty, 
    	$url) {
          $this->client = $client;
          $this->product = $product;
		  $this->products = $products;
    	  $this->orderInfo = $orderInfo;
    	  $this->totalDue = $totalDue;
          $this->qty = $qty;
          $this->url = $url;
        }
  
  /**
  * Get the message envelope.
  */
  public function build(): Envelope {
    return new Envelope(
      subject: 'Your order have been successfully received!'
    );
  }
  
  /**
  * Get the message content definition.
  */
  public function content(): Content {
    return new Content(
      markdown: 'emails.new-order',
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
