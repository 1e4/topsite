<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('games', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->bigInteger('category_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('url');
            $table->text('description');
            $table->string('banner_url')->nullable();
            $table->boolean('is_pending')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->bigInteger('votes_in')->default(0);
            $table->bigInteger('votes_out')->default(0);
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('created_by')
                ->references('id')
                ->on('users');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
}
