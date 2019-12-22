<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Offer;

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
        $offersQuantity = 100;

        factory(User::class, $usersQuantity)->create();
        factory(Company::class, $companiesQuantity)->create();
        factory(Offer::class, $offersQuantity)->create();
        $this->call(WorkerCompanySeeder::class);
    }
}
