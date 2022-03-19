<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table){
            $table->unsignedBigInteger('author');
            $table->foreign("author")
            ->references('users')
            ->on('id')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['author']); /* numero di elementi da togliere, nota le [] perché può essere multipla */
            $table->dropColumn('author'); /* darebbe problemi senza la precedente perché prima va tolta la relazione, va sganciata */
        });
    }
}
