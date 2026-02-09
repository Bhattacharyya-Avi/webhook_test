<?php

namespace Database\Seeders;

use App\Models\ChildProject;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class childProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "name" => "test",
                "project_url" => "http://holidaycalander.test",
                "webhook_token" => Str::random(64),
                "package_id" => "1",
            ],
            [
                "name" => "test2",
                "project_url" => "test2.test",
                "webhook_token" => Str::random(64),
                "package_id" => "2",
            ],
        ];

        foreach ($data as $key => $value) {
            ChildProject::create($value);
        }
    }
}
