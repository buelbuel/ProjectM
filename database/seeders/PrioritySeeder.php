<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Priority::factory()->count(6)->sequence(
            [ 'id' => 1, 'name' => 'Lowest', ],
            [ 'id' => 2, 'name' => 'Low', ],
            [ 'id' => 3, 'name' => 'Normal', ],
            [ 'id' => 4, 'name' => 'High', ],
            [ 'id' => 5, 'name' => 'Highest', ],
            [ 'id' => 6, 'name' => 'Critical', ]
        )->create();
    }
}
