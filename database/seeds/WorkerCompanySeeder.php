<?php

use App\Models\Worker;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class WorkerCompanySeeder extends Seeder
{

    public function run(Faker $faker)
    {
        $data = [];

        for($i = 1; $i < 250; $i++){
            $company = Company::all()->random();
            $worker = User::whereVerified(User::VERIFIED_USER)->get();
            $worker = $worker->random();

            $data[] = [
                'worker_id' => $worker->id,
                'company_id' => $company->id,
                'position' => $faker->word(),
                'salary' => $faker->numberBetween(1000, 100000)
                ];
        }

        DB::table('worker_company')->insert($data);
    }
}
