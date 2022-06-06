<?php

namespace Database\Seeders;

use App\Models\AccountBook;
use Illuminate\Database\Seeder;

class AccountBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountBook::firstOrCreate([
            'name' => '預設帳本(不可使用)'
        ]);
    }
}
