<?php

namespace Database\Seeders;

use App\Models\AccountItemType;
use Illuminate\Database\Seeder;

class AccountItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountItemType::firstOrCreate([
            'name' => '飲食',
            'image' => 'test',
            'account_book_id' => 1, // 附加在預設帳本上
            'in_out_type_id' => 1 //支出
        ]);
    }
}
