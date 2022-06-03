<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_item_types', function (Blueprint $table) {
            $table->id()->comment('紀錄分類編號');
            $table->string('name', 10)->comment('紀錄分類名稱');
            $table->string('image', 50)->comment('記錄分類圖像');
            $table->string('description')->nullable()->comment('紀錄分類備註');
            $table->timestamps();
        });

        Schema::table('account_item_types', function (Blueprint $table) {
            $table->foreignId('account_book_id')->comment('帳本編號')->constrained();
            $table->foreignId('in_out_type_id')->comment('收支類型編號')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_item_types', function (Blueprint $table) {
            $table->dropForeign('account_book_id');
            $table->dropForeign('in_out_type_id');
        });
    }
}
