<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string("salted_hash_id");
            $table->bigInteger("ticket_id");
            $table->enum("activity_type", ['1','2','3']);
            $table->bigInteger("created_by");
            $table->enum("lastmodified_by_type", ['1','2']);
            $table->bigInteger("lastmodified_by")->nullable();
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
        Schema::dropIfExists('activities');
    }
}
