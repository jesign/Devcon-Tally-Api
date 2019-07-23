<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('event_id');
            $table->text('description')->nullable();
            $table->integer('max_points')->default(0);
            $table->float('percentage', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.l
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criteria');
    }
}
