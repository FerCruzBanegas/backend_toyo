<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('code', 8);
            $table->mediumText('address');
            $table->string('phone', 32)->nullable();
            
            $table->integer('city_id')->unsigned();
            $table->integer('owner_id')->unsigned();

            $table->timestamps();
            $table->softDeletes('deleted_at');

            //relation
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreign('owner_id')->references('id')->on('owners')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        DB::statement('
            create fulltext index stores_code_fulltext
            on stores(code);
        ');

        DB::statement('
            create fulltext index stores_address_fulltext
            on stores(address);
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
