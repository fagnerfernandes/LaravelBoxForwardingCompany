<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BRCitiesZipSeeder extends Seeder
{

    protected $table = 'BRcitieszipcodes_csv';
    protected $csvFile = 'database/data/BRcitieszipcodes.csv';
    protected $delimiter = ',';
    protected $header = null;
    protected $iterator = 0;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table($this->table)->count() > 0) return;
        
        $csvFile = fopen(base_path('database/data/BRcitieszipcodes.csv'), 'r');
        if ($csvFile) {
            try {
                DB::table($this->table)->truncate();

                foreach($this->csvToArray() as $data) {
                    DB::table($this->table)->insert($data);
                }
            } catch (\Exception $exception) {
                Log::emergency("Erro ao carregar arquivo CSV. ".$exception->getMessage());
                Log::debug($exception);
            }
        }
    }


    protected function csvToArray() {
        $data = array();
        $resource = fopen(base_path($this->csvFile), 'r');
        while (($row = fgetcsv($resource, 1000, $this->delimiter)) !== false) {
            $is_mul_1000 = false;
            if (!$this->header) {
                $this->header = $row;
            } else {
                $this->iterator++;
                $data[] = array_combine($this->header, $row);
                if($this->iterator != 0 && $this->iterator % 1000 == 0){
                    $is_mul_1000 = true;
                    $chunk = $data;
                    $data = array();
                    yield $chunk;
                }
            }
        }

        fclose($resource);

        if(!$is_mul_1000){
            yield $data;
        }

        return;
    }
}
