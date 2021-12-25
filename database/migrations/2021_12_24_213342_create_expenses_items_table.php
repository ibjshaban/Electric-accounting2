<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_items', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('item_number');
            $table->double('amount');
            $table->double('price');
            $table->foreignId('expenses_id')->nullable()->references('id')->on('expenses')->nullOnDelete();
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
        Schema::dropIfExists('expenses_items');
    }
}
