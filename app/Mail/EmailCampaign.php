<?php

namespace App\Mail;

use App\Models\Campaing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailCampaign extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Campaing $campaign)
    {
        
    }

    /**
     * Informaçoes de cabeçalho do email
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->campaign->subject,
        );
    }

    /**
     * Conteudo do email 
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.email-campaign',
        );
    }

    
}
