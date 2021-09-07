<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('battery_code', 16);
            $table->tinyInteger('status')->default('1');
            
            $table->integer('store_id')->unsigned();
            $table->integer('customer_id')->unsigned();

            $table->timestamps();
            $table->softDeletes('deleted_at');

            //relation
            $table->foreign('store_id')->references('id')->on('stores')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreign('customer_id')->references('id')->on('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        DB::statement('
            create fulltext index tickets_battery_code_fulltext
            on tickets(battery_code);
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
