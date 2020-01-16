<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Vacancy;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $usersQuantity = 300;
        $companiesQuantity = 20;
        $offersQuantity = 200;
        $vacancyQuantity = 200;

        factory(User::class, $usersQuantity)->create();
        factory(Company::class, $companiesQuantity)->create();
        factory(Vacancy::class, $vacancyQuantity)->create();
        $this->call(WorkerCompanySeeder::class);
        factory(Offer::class, $offersQuantity)->create();
    }
}
