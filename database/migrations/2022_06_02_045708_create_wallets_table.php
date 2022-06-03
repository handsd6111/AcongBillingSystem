<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id()->comment('錢包編號');
            $table->string('name', 20)->comment('錢包名稱');
            $table->decimal('balance')->comment('錢包餘額');
            $table->string('description')->nullable()->comment('錢包備註');
            $table->timestamps();
            $table->char('member_id', 14)->comment('成員編號');
        });
        Schema::table('wallets', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets', function (Blueprint $table) {
            $table->dropForeign('member_id');
        });
    }
}
