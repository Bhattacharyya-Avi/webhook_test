<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class packageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => "silver",
                'config' => '{"maxMemberNo":"200"}',
            ],

            [
                'name' => "gold",
                'config' => '{"maxMemberNo":"500"}',
            ],
        ];

        foreach ($data as $key => $value) {
            Package::create($value);
        }
    }
}
