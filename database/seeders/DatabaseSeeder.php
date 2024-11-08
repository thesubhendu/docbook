<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Patient',
            'email' => 'pat@docbook.test',
        ]);

        User::factory()->create([
            'name' => 'Doctor',
            'user_type' => 'doctor',
            'email' => 'doc@docbook.test',
        ]);

        $specialty = ['ICU','Urology','Cardio','Physio','Ortho','Dermatologist','ENT','General'];

        foreach ($specialty as $s) {
            \App\Models\Specialization::create([
                'name' => $s
            ]);
        }

    }
}
