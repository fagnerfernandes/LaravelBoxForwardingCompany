<?php

namespace Database\Seeders;

use App\Models\Mailbox;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailboxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mailboxes = [
            [
                'description' => 'Comercial',
                'dst_mail' => 'comercial@company.com'
            ],
            [
                'description' => 'Financeiro',
                'dst_mail' => 'financeiro@company.com'
            ],
            [
                'description' => 'Suporte',
                'dst_mail' => 'suporte@company.com'
            ]
        ];

        Mailbox::truncate();
        
        foreach ($mailboxes as $mailbox) {
            Mailbox::create($mailbox);
        }
    }
}
