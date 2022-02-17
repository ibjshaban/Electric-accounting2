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
            $table->double('quantity');
            $table->double('price');
            $table->double('paid_amount')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->foreignId("filling_id")->nullable()->constrained("fillings")->references("id")->nullOnDelete();
            $table->foreignId("stock_id")->nullable()->constrained("stocks")->references("id")->nullOnDelete();
            $table->foreignId("revenue_id")->nullable()->constrained("revenues")->references("id")->nullOnDelete();
            $table->foreignId("city_id")->nullable()->constrained("cities")->references("id")->nullOnDelete();
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
