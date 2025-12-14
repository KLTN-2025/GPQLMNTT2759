<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MasterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tieu_de;
    public $view;
    public $noi_dung;

    public function __construct($tieu_de, $view, $noi_dung)
    {
        $this->tieu_de = $tieu_de;
        $this->view = $view;
        $this->noi_dung = $noi_dung;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->tieu_de,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.components.' . $this->view,
            with: $this->noi_dung,
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
