<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialty;
use App\Models\User;
use App\Policies\AppointmentPolicy;
use App\Policies\DoctorPolicy;
use App\Policies\PatientPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SpecialtyPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Gate::policy(Patient::class,PatientPolicy::class);
        Gate::policy(Doctor::class,DoctorPolicy::class);
        Gate::policy(Appointment::class,AppointmentPolicy::class);
        Gate::policy(Role::class,RolePolicy::class);
        Gate::policy(Permission::class,PermissionPolicy::class);
        Gate::policy(Specialty::class,SpecialtyPolicy::class);
        Gate::policy(User::class,UserPolicy::class);
    }
}
