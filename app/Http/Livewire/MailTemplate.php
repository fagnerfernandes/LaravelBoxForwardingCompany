<?php

namespace App\Http\Livewire;

use App\Enums\MailTemplateTypesEnum;
use App\Models\MailTemplate as ModelsMailTemplate;
use App\Traits\EmailVariablesTrait;
use Livewire\Component;

class MailTemplate extends Component
{
    use EmailVariablesTrait;

    public $templateId = null;
    public $name = '';
    public $template_type = '';
    public $subject = '';
    public $content = '';
    public $mailTemplate = null;

    public function render()
    {
        return view('livewire.mail-template');
    }

    public function mount(null|ModelsMailTemplate $mailTemplate = null) {
        if ($mailTemplate) {
            $this->mailTemplate = $mailTemplate;
            $this->templateId = $mailTemplate->id;
            $this->name = $mailTemplate->name;
            $this->template_type = $mailTemplate->type->value ?? null;
            $this->subject = $mailTemplate->subject;
            $this->content = $mailTemplate->content;
        }
    }

    public function updated($field) {
        $this->validateOnly($field);
    }

    public function getTypesProperty() {
        $types = [];
        foreach (MailTemplateTypesEnum::cases() as $mailTemplateType) {
            if (ModelsMailTemplate::where('type', $mailTemplateType)->count() > 0) continue;
            $types[] = [
                'value' => $mailTemplateType->value,
                'name' => MailTemplateTypesEnum::asText($mailTemplateType)
            ];
        }

        return $types;
    }

    public function getVariablesProperty() {
        if ($this->template_type) {
            return $this->getVariables(MailTemplateTypesEnum::tryFrom($this->template_type));  
        } else {
            return [];
        }
    }

    public function storeTemplate() {
        //dd($this->type);
        $this->validate();

        if ($this->templateId) {
            $this->mailTemplate->update([
                'name' => $this->name,
                'type' => $this->template_type,
                'subject' => $this->subject,
                'content' => $this->content
            ]);

            flash()->success('Template alterado com sucesso!');
            return redirect()->route('mail_templates.index');

        } else {
            //create
            ModelsMailTemplate::create([
                'name' => $this->name,
                'type' => $this->template_type,
                'subject' => $this->subject,
                'content' => $this->content
            ]);

            flash()->success('Template salvo com sucesso!');
            return redirect()->route('mail_templates.index');
        }

    }

    protected $rules = [
        'name' => 'required|string|min:3|max:200',
        'template_type' => 'required',
        'subject' => 'required',
        'content' => 'required'
    ];

    protected $validationAttributes = [
        'name' => 'Nome',
        'template_type' => 'Tipo',
        'subject' => 'Assunto',
        'content' => 'Template'
    ];
}
