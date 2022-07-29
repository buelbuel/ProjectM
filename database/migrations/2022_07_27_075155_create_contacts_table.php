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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('account_id')->constrained('accounts');

            $table->string('number', 6)->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('salutation')->nullable(); // TODO: Make enum
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();

            $table->string('shipping_street')->nullable();
            $table->string('shipping_city')->nullable();
            $table->integer('shipping_zip')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
