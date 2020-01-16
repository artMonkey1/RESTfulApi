<?php

namespace App\Providers;

use App\Models\Applicant;
use App\Models\Chief;
use App\Models\User;
use App\Models\Worker;
use App\Policies\ApplicantPolicy;
use App\Policies\ChiefPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Worker::class => WorkerPolicy::class,
        Chief::class => ChiefPolicy::class,
        User::class => UserPolicy::class,
        Applicant::class => ApplicantPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-actions', function ($user){
            return $user->isAdmin;
        });

        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::tokensCan([
            'manage-account' => 'Manage a profile of user',
            'manage-companies' => 'Manage a chief\'s companies',
            'manage-jobs' => 'Read about jobs and quit from jobs',
            'manage-offers' => 'Answer on offers, send and delete self offers',
            'manage-vacancies' => 'Create, update, delete vacancies'
        ]);
    }
}
