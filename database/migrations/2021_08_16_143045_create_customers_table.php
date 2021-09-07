<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('names', 128);
            $table->string('surnames', 128);
            $table->string('phone', 32);
            $table->string('ci', 32)->unique();
            $table->mediumText('address')->nullable();

            $table->timestamps();
            $table->softDeletes('deleted_at');
        });

        DB::statement('
            create fulltext index customers_names_surnames_fulltext
            on customers(names, surnames);
        ');

        DB::statement('
            create fulltext index customers_ci_fulltext
            on customers(ci);
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
