<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_company', function (Blueprint $table) {
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('company_id');
            $table->string('position');
            $table->string('salary');
            $table->timestamps();

            $table->foreign('worker_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_company');
    }
}
