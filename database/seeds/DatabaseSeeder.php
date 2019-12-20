<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userQuantity = 300;
        $companyQuantity = 20;

        factory(User::class, $userQuantity)->create();
        factory(Company::class, $companyQuantity)->create();

        $this->call(WorkerCompanySeeder::class);
    }
}
