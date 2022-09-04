<?php

namespace Database\Seeders;

use App\Models\PurchaseStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchaseStatuses = [
            [
                'id' => 1,
                'description' => 'Aguardando Pagamento'
            ],
            [
                'id' => 2,
                'description' => 'Aguardando Aprovação'
            ],
            [
                'id' => 3,
                'description' => 'Pago'
            ],
            [
                'id' => 4,
                'description' => 'Não Autorizado'
            ],
            [
                'id' => 5,
                'description' => 'Cancelado'
            ],
        ];

        foreach ($purchaseStatuses as $purchaseStatus) {
            PurchaseStatus::updateOrCreate($purchaseStatus);
        }
    }
}
