<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('author')
            ->constrained('users')  //prende automaticamente l'id  (vai SEMPRE DI migrate:refresh)
            ->onDelete('restrict');
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
            $table->dropForeign(['author']); /* nota le [] perché può essere multipla */
            $table->dropColumn('author'); /* darebbe problemi senza la precedente perché prima va tolta la relazione, va sganciata */
        });
    }
}
