<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHashKeyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hash_map', function (Blueprint $table) {
            $table->renameColumn('key', 'hash_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hash_map', function (Blueprint $table) {
            $table->renameColumn('hash_key', 'key');
        });
    }
}
