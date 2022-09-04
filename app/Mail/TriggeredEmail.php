<?php

namespace App\Mail;

use App\Models\MailTemplate;
use App\Traits\EmailVariablesTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TriggeredEmail extends Mailable
{
    use Queueable, SerializesModels, EmailVariablesTrait;

    public $variables;
    public $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $variables, MailTemplate $template)
    {
        $this->variables = $variables;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->template_substitution($this->template->subject, $this->variables);

        $content = $this->template_substitution($this->template->content, $this->variables);

        return $this->subject($subject)
                    ->markdown('emails.triggered_email', [
                        'content' => $content
                    ]);
    }
}
