<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_payments', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->string('loan_id', 40);
            $table->date('date');
            $table->decimal('amount', 12, 2);
            $table->decimal('amount_paid', 12, 2)->nullable();
            $table->string('status', 40);
            $table->timestamps();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_payments');
    }
};
