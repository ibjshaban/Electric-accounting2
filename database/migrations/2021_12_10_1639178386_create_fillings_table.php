<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// Auto Schema  By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class CreateFillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fillings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quantity');
            $table->bigInteger('price');
            $table->foreignId("supplier_id")->constrained("suppliers")->references("id");
            $table->date('filling_date');
            $table->longtext('note')->nullable();
            $table->string('name');
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
        Schema::dropIfExists('fillings');
    }
}