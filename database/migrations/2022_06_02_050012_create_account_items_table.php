<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_items', function (Blueprint $table) {
            $table->id()->comment('帳目編號');
            $table->string('description', 50)->nullable()->comment('帳目備註');
            $table->decimal('money')->comment('收支多少金額');
            $table->string('location', 50)->nullable()->comment('收支地點');
            $table->string('image', 50)->nullable()->comment('相關照片');
            $table->dateTime('in_out_date')->comment('收支日期');
            $table->timestamps();
        });
        Schema::table('account_items', function (Blueprint $table) {
            $table->foreignId('account_book_id')->comment('帳本編號')->constrained();
            $table->foreignId('wallet_id')->comment('錢包編號')->constrained();
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
        Schema::dropIfExists('account_items', function (Blueprint $table) {
            $table->dropForeign('account_book_id');
            $table->dropForeign('wallet_id');
            $table->dropForeign('in_out_type_id');
        });
    }
}
