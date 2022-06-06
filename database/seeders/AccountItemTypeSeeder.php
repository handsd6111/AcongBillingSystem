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
            ['飲食', 'imgPath'], //imgPath是路徑
            ['日用', ''],
            ['交通', ''],
            ['社交', ''],
            ['住房物業', ''],
            ['禮物', 'img'],
            ['通信', ''],
            ['服飾', ''],
            ['娛樂', ''],
            ['美容', ''],
            ['醫療', ''],
            ['稅金', ''],
            ['教育', ''],
            ['寶寶', ''],
            ['寵物', ''],
            ['旅行', ''],
            ['轉帳', ''],
        ];
        $inItem = [
            ['工資', 'imgPath'],
            ['獎金', ''],
            ['理財投資', ''],
            ['兼職', ''],
            ['轉帳', ''],
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
