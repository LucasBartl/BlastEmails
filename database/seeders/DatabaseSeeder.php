<?php

namespace Database\Seeders;

use App\Models\EmailList;
use App\Models\Subscriber;
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

        //Chamando todos os seeders criados 
        $this->call([

            UserSeeder::class,
            EmailListSeeder::class,
            TemplateSeeder::class,
            CampaingSeeder::class


        ]);
    }
}
