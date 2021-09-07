<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('names', 128);
            $table->string('surnames', 128);
            $table->string('phone', 32);
            $table->string('ci', 32)->unique()->nullable();
            $table->mediumText('address')->nullable();

            $table->integer('user_id')->unsigned();

            $table->timestamps();
            $table->softDeletes('deleted_at');

            //relation
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        DB::statement('
            create fulltext index owners_names_surnames_fulltext
            on owners(names, surnames);
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owners');
    }
}
