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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('status_id')->nullable()->constrained('statuses');


            $table->string('number', 6)->unique();
            $table->string('name');
            $table->longText('description')->nullable();

            $table->dateTime("completed_at")->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();

            $table->double('hourly_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
