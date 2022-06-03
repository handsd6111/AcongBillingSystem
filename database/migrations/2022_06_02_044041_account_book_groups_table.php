<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccountBookGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 帳本群組 table
        Schema::create('account_book_groups', function (Blueprint $table) {
            $table->id()->comment('帳本群組編號');
            $table->integer('authority')->comment('成員在帳本群組內的權限');
            $table->timestamps();
            $table->char('member_id', 14)->comment('成員編號');
        });

        Schema::table('account_book_groups', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreignId('account_book_id')->comment('帳本編號')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_book_groups', function (Blueprint $table) {
            $table->dropForeign('member_id');
            $table->dropForeign('account_books_id');
        });
    }
}
