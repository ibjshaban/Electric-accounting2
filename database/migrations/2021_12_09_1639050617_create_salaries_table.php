<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// Auto Schema  By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
$table->foreignId("admin_id")->nullable()->constrained("admins")->onUpdate("cascade")->nullOnDelete();
            $table->double('total_amount');
            $table->double('discount');
            $table->double('salary');
            $table->string('note')->nullable();
            $table->date('payment_date');
            $table->foreignId("employee_id")->nullable()->constrained("employees")->references("id")->nullOnDelete();
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
        Schema::dropIfExists('salaries');
    }
}
