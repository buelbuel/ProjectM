<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
        DB::table('priorities')->insert(['id' => 1, 'name' => 'Lowest']);
        DB::table('priorities')->insert(['id' => 2, 'name' => 'Low']);
        DB::table('priorities')->insert(['id' => 3, 'name' => 'Normal']);
        DB::table('priorities')->insert(['id' => 4, 'name' => 'High']);
        DB::table('priorities')->insert(['id' => 5, 'name' => 'Highest']);
        DB::table('priorities')->insert(['id' => 6, 'name' => 'Critical']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('priorities');
    }
};
