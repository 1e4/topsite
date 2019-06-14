<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function(Blueprint $blueprint)
        {
            $blueprint->boolean("pending")->default(false);
            $blueprint->boolean("premium")->default(false);
            $blueprint->bigInteger("votes_in")->default(0);
            $blueprint->bigInteger("votes_out")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
