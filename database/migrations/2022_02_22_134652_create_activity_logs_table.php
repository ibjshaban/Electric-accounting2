<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->boolean('checked')->default(0);
            $table->integer('note_type');
            $table->timestamp('date_at');
            $table->string('statement');
            $table->double('amount');
            $table->enum('operation_type',['store','update','delete']);
            $table->foreignId('city_id')->nullable();
            $table->foreignId('revenue_id')->nullable();
            $table->foreignId("admin_id")->constrained("admins");
            $table->string('url')->nullable();
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
        Schema::dropIfExists('activity_logs');
    }
}
