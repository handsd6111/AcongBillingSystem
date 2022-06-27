<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoColumnToAccountBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_books', function (Blueprint $table) {
            $table->string('photo', 50)->nullable()->comment('帳本照片');
            $table->string('description')->nullable()->comment('帳本描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_books', function (Blueprint $table) {
            //
        });
    }
}
