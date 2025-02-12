<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 成員 table
        Schema::create('members', function (Blueprint $table) {
            $table->char('id', 14)->primary()->comment('成員編號');
            $table->string('account', 30)->comment('成員帳號');
            $table->string('name', 30)->comment('成員姓名');
            $table->char('password', 97)->comment('成員密碼');
            $table->string('avatar', 50)->nullable()->comment('成員頭像');
            $table->string('introduction')->nullable()->comment('成員自介');
            $table->string('phone', 30)->comment('成員手機號碼');
            $table->integer('authority')->default(1)->comment('成員權限，0:禁止、1:普通、2:管理員、3:最高管理員');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
