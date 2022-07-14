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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
        DB::table('statuses')->insert(['id' => 1, 'name' => 'Backlog']);
        DB::table('statuses')->insert(['id' => 2, 'name' => 'To Do']);
        DB::table('statuses')->insert(['id' => 3, 'name' => 'In Progress']);
        DB::table('statuses')->insert(['id' => 4, 'name' => 'Waiting']);
        DB::table('statuses')->insert(['id' => 5, 'name' => 'In Testing']);
        DB::table('statuses')->insert(['id' => 6, 'name' => 'Completed']);
        DB::table('statuses')->insert(['id' => 7, 'name' => 'Can\'t Complete']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
};
