<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $phone, $subject, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->subject('['.config('app.name').' - Formulário de Contato] '.$this->subject)
        return $this->subject($this->subject)
                    ->markdown('emails.contact_form')
                    ->withName($this->name)
                    ->withEmail($this->email)
                    ->withPhone($this->phone)
                    ->withMessage($this->message);
    }
}
