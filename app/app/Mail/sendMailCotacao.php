<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailCotacao extends Mailable
{
    use Queueable, SerializesModels;

    public $dadosCotacao;

    public function __construct($dadosCotacao)
    {
        $this->dadosCotacao = $dadosCotacao;
    }

    public function build()
    {
        $this->subject(subject: 'Nova Cotação Feita');
        $this->to('faylouti04@gmail.com', 'teste');
        return $this->view('mail.sendMainCotacao');
    }
}
