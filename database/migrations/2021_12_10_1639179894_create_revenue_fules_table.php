<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// Auto Schema  By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class CreateRevenueFulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenue_fules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quantity');
            $table->bigInteger('price');
            $table->bigInteger('paid_amount')->nullable();
            $table->foreignId("filling_id")->constrained("fillings")->references("id");
            $table->foreignId("stock_id")->constrained("stocks")->references("id");
            $table->foreignId("revenue_id")->constrained("revenues")->references("id");
            $table->foreignId("city_id")->constrained("cities")->references("id");
            $table->string('note')->nullable();
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
        Schema::dropIfExists('revenue_fules');
    }
}
