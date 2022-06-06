<?php

namespace Database\Seeders;

use App\Models\InOutType;
use Illuminate\Database\Seeder;

class InOutTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InOutType::firstOrCreate([
            'name' => '支出'
        ]);
        InOutType::firstOrCreate([
            'name' => '收入'
        ]);
    }
}
