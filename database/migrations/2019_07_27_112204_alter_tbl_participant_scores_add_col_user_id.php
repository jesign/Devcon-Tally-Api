<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblParticipantScoresAddColUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participant_scores', function (Blueprint $table) {
            $table->integer('user_id')->comment('user if or judge')->after('score');

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participant_scores', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
