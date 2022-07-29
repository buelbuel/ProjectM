<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Status::factory()->count(7)->sequence(
            [ 'id' => 1, 'name' => 'Backlog', ],
            [ 'id' => 2, 'name' => 'To Do', ],
            [ 'id' => 3, 'name' => 'In Progress', ],
            [ 'id' => 4, 'name' => 'Waiting', ],
            [ 'id' => 5, 'name' => 'In Testing', ],
            [ 'id' => 6, 'name' => 'Completed', ],
            [ 'id' => 7, 'name' => 'Can\'t Complete', ]
        )->create();
    }
}
