<?php

namespace App\Http\Livewire;

use App\Mail\ContactForm as MailContactForm;
use App\Models\Mailbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $departments = [];
    public $department = null;
    public $subject = '';
    public $message = '';
    public $success = false;


    public function render()
    {
        return view('livewire.contact-form');
    }

    public function mount() {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone_number;
        $this->departments = Mailbox::select(['id', 'description'])->orderBy('description')->get();
    }

    public function updated($field) {
        $this->validateOnly($field);
    }

    public function sendMessage() {
        $this->validate();
        $department = Mailbox::find($this->department);
        $subject = $department->description.' - '.$this->subject;
        //Mail::to($department->dst_mail)
        Mail::to('fagner.ti@gmail.com')
            ->send(new MailContactForm(
            $this->name,
            $this->email,
            $this->phone,
            $subject,
            $this->message
        ));
        $this->clear(); 
    }

    protected $rules = [
        /* 'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required', */
        'department' => 'required|exists:mailboxes,id',
        'subject' => 'required|min:3|max:250',
        'message' => 'required|min:5'
    ];

    protected $messages = [
        /* 'name.required' => 'Campo Nome não preenchido.',
        'email.required' => 'Campo E-mail não informado.',
        'email.email' => 'Endereço de e-mail informado não parede ser válido.',
        'phone.required' => 'Campo Telefone não preenchido.', */
        'department.required' => 'Nenhum Departamento selecionado.',
        'department.exists' => 'Departamento informado é inválido.',
        'subject.required' => 'Campo Assunto não preenchido.',
        'subject.min' => 'Assunto deve ter pelo menos 3 caracteres.',
        'subject.max' => 'Assunto não pode ter mais de 250 caracteres.',
        'message.required' => 'Campo Mensagem não preenchido.',
        'message.min' => 'Mensagem deve ter pelo menos 5 caracteres.' 
    ];

    protected $attributes = [];

    public function clear() {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone_number;
        $this->department = null;
        $this->subject = '';
        $this->message = '';
        $this->success = true;
    }
}
