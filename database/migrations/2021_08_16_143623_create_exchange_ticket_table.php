<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_ticket', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('exchange_id')->unsigned();
            $table->integer('ticket_id')->unsigned();
            
            $table->timestamps();

            //relation
            $table->foreign('exchange_id')->references('id')->on('exchanges')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('ticket_id')->references('id')->on('tickets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_ticket');
    }
}
