<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // // 成員 table
        // Schema::create('members', function (Blueprint $table) {
        //     $table->char('member_id', 13)->primary()->comment('成員編號');
        //     $table->string('member_account', 30)->comment('成員帳號');
        //     $table->string('member_name', 30)->comment('成員姓名');
        //     $table->string('member_password', 35)->comment('成員密碼');
        //     $table->string('member_avatar', 50)->nullable()->comment('成員頭像');
        //     $table->string('member_introduction')->nullable()->comment('成員自介');
        //     $table->integer('member_authority')->comment('成員權限');
        //     $table->timestamps();
        // });
        // // 帳本 table
        // Schema::create('account_book', function (Blueprint $table) {
        //     $table->char('account_book_id', 14)->primary()->comment('帳本編號');
        //     $table->string('account_book_name', 20)->comment('帳本的名稱');
        //     $table->timestamps();
        // });
        // 帳本群組 table
        // Schema::create('account_book_group', function (Blueprint $table) {
        //     $table->id('account_book_group_id')->comment('帳本群組編號');
        //     $table->char('member_id', 14)->comment('成員編號');
        //     $table->foreign('member_id')->references('member_id')->on('member');
        //     $table->char('account_book_id', 14)->comment('帳本編號');
        //     $table->foreign('account_book_id')->references('account_book_id')->on('account_book');
        //     $table->integer('account_book_group_authority')->comment('成員在帳本群組內的權限');
        //     $table->timestamps();
        // });
        // // 錢包 table
        // Schema::create('wallet', function (Blueprint $table) {
        //     $table->id('wallet_id')->comment('錢包編號');
        //     $table->string('wallet_name', 20)->comment('錢包名稱');
        //     $table->decimal('wallet_balance')->comment('錢包餘額');
        //     $table->string('wallet_description')->nullable()->comment('錢包備註');
        //     $table->char('member_id', 14)->comment('成員編號');
        //     $table->foreign('member_id')->references('member_id')->on('member');
        //     $table->timestamps();
        // });
        // // 收支分類 table
        // Schema::create('in_out', function (Blueprint $table) {
        //     $table->integer('in_out_id')->primary()->comment('收支分類編號');
        //     $table->char('in_out_name', 2)->comment('收入還是支出');
        // });
        // // 帳本紀錄 table
        // Schema::create('account_record', function (Blueprint $table) {
        //     $table->id('account_record_id')->comment('帳本紀錄編號');
        //     $table->string('account_record_description', 50)->nullable()->comment('帳本紀錄備註');
        //     $table->decimal('account_record_money')->comment('收支多少金額');
        //     $table->string('account_record_location', 50)->nullable()->comment('收支地點');
        //     $table->string('account_record_image', 50)->nullable()->comment('相關照片');
        //     $table->dateTime('account_record_date')->comment('收支日期');
        //     $table->char('account_book_id', 14)->comment('帳本編號');
        //     $table->foreign('account_book_id')->references('account_book_id')->on('account_book');
        //     $table->foreignId('wallet_id')->constrained('wallet', 'wallet_id')->comment('錢包編號');
        //     $table->integer('in_out_id')->comment('收支分類編號');
        //     $table->foreign('in_out_id')->references('in_out_id')->on('in_out');
        //     $table->timestamps();
        // });
        // // 紀錄分類 table
        // Schema::create('record_type', function (Blueprint $table) {
        //     $table->id('record_type_id')->comment('紀錄分類編號');
        //     $table->string('record_type_name', 10)->comment('紀錄分類名稱');
        //     $table->string('record_type_image', 50)->comment('記錄分類圖像');
        //     $table->string('record_type_description')->comment('紀錄分類備註');
        //     $table->char('account_book_id', 14)->comment('帳本編號');
        //     $table->foreign('account_book_id')->references('account_book_id')->on('account_book');
        //     $table->integer('in_out_id')->comment('收支分類編號');
        //     $table->foreign('in_out_id')->references('in_out_id')->on('in_out');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('record_type', function (Blueprint $table) {
        //     $table->dropForeign('account_book_id');
        //     $table->dropForeign('in_out_id');
        // });
        // Schema::dropIfExists('account_record', function (Blueprint $table) {
        //     $table->dropForeign('account_book_id');
        //     $table->dropForeign('in_out_id');
        //     $table->dropForeign('wallet_id');
        // });
        // Schema::dropIfExists('in_out');
        // Schema::dropIfExists('wallet', function (Blueprint $table) {
        //     $table->dropForeign('member_id');
        // });
        // Schema::dropIfExists('account_book_group', function (Blueprint $table) {
        //     $table->dropForeign('member_id');
        //     $table->dropForeign('account_book_id');
        // });
        // Schema::dropIfExists('account_book');
        // Schema::dropIfExists('member');
    }
}
