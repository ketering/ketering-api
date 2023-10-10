<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $companies = [
            'Alicorn',
            'Amplitudo',
            'Bild Studio',
            'Codeus',
            'Coinis',
            'DataDesign',
            'Oykos Development',
            'Logate',
            'Fleka',
            'Domain',
            'Čikom',
            'AI Solution',
            'Pos4me',

            'Digital Bee',
            'Code Pixel',
            'Arhimed',
            'Business Intelligence Consulting doo Podgorica',
            'Omitech',
            'Codelab',
            'Sky Sat',
            'Progmata',
            'ECS',
            '2BI',
            'Optimus Consulting',
            'Sky Express',
            'Simes Inžinjering',
            'Telemont',
            'Studio Lasso',
            'Profit app',
            'ZZI',
            '3d soba',
            'Navira IT',

            'Telekom',
            'NTP',
            'Tehnopolis'
        ];
        foreach ($companies as $company) {
            Company::factory([
                'name' => $company,
            ])->create();
        }
    }
}
