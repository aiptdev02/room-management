<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DefaultMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    public $view;
    public $maildata;
    public $attachments = [];
    public function __construct($subject, $view, $maildata, $attachments = [])
    {
        $this->subject = $subject;
        $this->view = $view;
        $this->maildata = $maildata;
        $this->attachments = $attachments;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: $this->view,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
        //Attachment::fromPath(public_path('uploads/quotes/'))->as('1707806086_delivery-truck.png')->withMime('image/png')
        // $attach = [];
        // foreach ($this->attachments as $key => $file) {
        //     $attach[] = Attachment::fromPath($file['path'])->as($file['file']);
        // }

    }
}
