<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// Auto Schema  By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class CreaterevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId("admin_id")->nullable()->constrained("admins")->onUpdate("cascade")->nullOnDelete();
            $table->string('name');
            $table->date('open_date');
            $table->date('close_date')->nullable();
            $table->double('total_amount');
            $table->boolean('status')->default(1);
            $table->foreignId("city_id")->nullable()->constrained("cities")->references("id")->nullOnDelete();
			$table->softDeletes();

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
        Schema::dropIfExists('revenues');
    }
}
