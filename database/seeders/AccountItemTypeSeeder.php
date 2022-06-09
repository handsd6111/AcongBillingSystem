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
        $outItem = [
            ['飲食', 'food.png'],
            ['日用', 'dailyUse.png'],
            ['交通', 'traffic.png'],
            ['社交', 'social.png'],
            ['住房物業', 'home.png'],
            ['禮物', 'gift.png'],
            ['通信', 'phone.png'],
            ['服飾', 'clothes.png'],
            ['娛樂', 'entertainment.png'],
            ['美容', 'cosmetics.png'],
            ['醫療', 'medical.png'],
            ['稅金', 'taxes.png'],
            ['教育', 'educate.png'],
            ['寶寶', 'baby.png'],
            ['寵物', 'pets.png'],
            ['旅行', 'travel.png'],
            ['轉帳', 'transfer.png'],
        ];
        $inItem = [
            ['工資', 'salary.png'],
            ['獎金', 'bonus.png'],
            ['理財投資', 'invest.png'],
            ['兼職', 'partTime.png'],
            ['轉帳', 'transfer.png'],
        ];
        foreach ($outItem as $value) {
            AccountItemType::firstOrCreate([
                'name' => $value[0],
                'image' =>$value[1],
                'account_book_id' => 1, // 附加在預設帳本上
                'in_out_type_id' => 1 //支出
            ]);
        }
        foreach($inItem as $value){
            AccountItemType::firstOrCreate([
                'name' => $value[0],
                'image' =>$value[1],
                'account_book_id' => 1, // 附加在預設帳本上
                'in_out_type_id' => 2 //支出
            ]);
        }
    }
}
