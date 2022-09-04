<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

class WhatsappCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:whatsapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia uma mensagem para o whatsapp';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $twilio = new Client(env('TWILIO_ID'), env('TWILIO_TOKEN'));

        $message = $twilio->messages ->create("+5511969159344", array(        
            "from" => env('TWILIO_NUMBER'),
            "body" => "Your message" 
        )); 
 
        dd($message->sid);
    }
}
