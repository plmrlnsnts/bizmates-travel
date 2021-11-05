<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithFaker;

    public function run()
    {
        $this->setUpFaker();

        foreach (range(1, 100) as $i) {
            $teacher = DB::table('trn_teacher')->insertGetId([
                'nickname' => $this->faker->name(),
                'status' => $this->faker->randomElement([0, 1, 2]),
            ]);

            collect($this->faker->randomElements(
                [1, 2, 3], rand(1, 3))
            )->each(function ($role) use ($teacher) {
                DB::table('trn_teacher_role')->insert([
                    'teacher_id' => $teacher,
                    'role' => $role,
                ]);
            });

            collect([
                '2020-01-01 08:00:00',
                '2020-01-01 09:00:00',
            ])->each(function ($datetime) use ($teacher) {
                DB::table('trn_time_table')->insert([
                    'teacher_id' => $teacher,
                    'lesson_datetime' => $datetime,
                    'status' => $this->faker->randomElement([1, 2, 3]),
                ]);

                DB::table('trn_evaluation')->insert([
                    'teacher_id' => $teacher,
                    'lesson_datetime' => $datetime,
                    'result' => $this->faker->randomElement([1, 2]),
                ]);
            });
        }
    }
}
