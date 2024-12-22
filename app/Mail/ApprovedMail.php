<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct($content, $pdfPath)
    {
        $this->content = $content;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->view('emails.approved')
                    ->with(['content' => $this->content])
                    ->attach($this->pdfPath, [
                        'as' => 'certificate.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
