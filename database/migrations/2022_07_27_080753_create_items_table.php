<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignIdFor(Project::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Team::class)->constrained();
            $table->string('status')->default('Backlog');
            $table->string('priority')->default('Normal');

            $table->string('number', 6)->unique();
            $table->string('name');
            $table->longText('description')->nullable();

            $table->dateTime("completed_at")->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();

            $table->decimal('tracked', 4)->nullable();
            $table->decimal('estimated', 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
