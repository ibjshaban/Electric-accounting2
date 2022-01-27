<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// Auto Schema  By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class CreateOtherOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId("admin_id")->nullable()->constrained("admins")->onUpdate("cascade")->nullOnDelete();
            $table->string('name');
            $table->double('price');
            $table->date('date');
            $table->string('note')->nullable();
            $table->foreignId("revenue_id")->nullable()->constrained("revenues")->references("id")->nullOnDelete();
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
        Schema::dropIfExists('other_operations');
    }
}
