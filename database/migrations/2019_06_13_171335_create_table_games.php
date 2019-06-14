<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid("uuid");
            $table->string("url");
            $table->string("name");
            $table->text("description");
            $table->bigInteger("category_id")->unsigned();
            $table->string("slug");
            $table->boolean("pending")->default(false);
            $table->boolean("premium")->default(false);
            $table->bigInteger("votes_in")->default(0);
            $table->bigInteger("votes_out")->default(0);
            $table->timestamps();

            $table->foreign("category")
                ->references("id")
                ->on("categories");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
