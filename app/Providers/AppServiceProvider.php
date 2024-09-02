<?php

namespace App\Providers;

use App\Models\Actor;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\ActorRepository;
use App\Repositories\LapduRepository;
use App\Repositories\SaldoRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\EksekusiRepository;
use App\Repositories\PekerjaanRepository;
use App\Repositories\AccessDataRepository;
use App\Repositories\PenuntutanRepository;
use App\Repositories\PenyidikanRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\FileStorageRepository;
use App\Repositories\SatuanKerjaRepository;
use App\Repositories\JenisPerkaraRepository;
use App\Repositories\PenyelidikanRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ActorRepositoryInterface;
use App\Repositories\Interfaces\LapduRepositoryInterface;
use App\Repositories\Interfaces\SaldoRepositoryInterface;
use App\Repositories\Interfaces\EksekusiRepositoryInterface;
use App\Repositories\Interfaces\PekerjaanRepositoryInterface;
use App\Repositories\Interfaces\AccessDataRepositoryInterface;
use App\Repositories\Interfaces\PenuntutanRepositoryInterface;
use App\Repositories\Interfaces\PenyidikanRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\FileStorageRepositoryInterface;
use App\Repositories\Interfaces\SatuanKerjaRepositoryInterface;
use App\Repositories\Interfaces\JenisPerkaraRepositoryInterface;
use App\Repositories\Interfaces\PenyelidikanRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LapduRepositoryInterface::class, LapduRepository::class);
        $this->app->bind(SaldoRepositoryInterface::class, SaldoRepository::class);
        $this->app->bind(PenyelidikanRepositoryInterface::class, PenyelidikanRepository::class);
        $this->app->bind(JenisPerkaraRepositoryInterface::class, JenisPerkaraRepository::class);
        $this->app->bind(SatuanKerjaRepositoryInterface::class, SatuanKerjaRepository::class);
        $this->app->bind(ActorRepositoryInterface::class, ActorRepository::class);
        $this->app->bind(FileStorageRepositoryInterface::class, FileStorageRepository::class);
        $this->app->bind(PekerjaanRepositoryInterface::class, PekerjaanRepository::class);
        $this->app->bind(PenyidikanRepositoryInterface::class, PenyidikanRepository::class);
        $this->app->bind(PenuntutanRepositoryInterface::class, PenuntutanRepository::class);
        $this->app->bind(EksekusiRepositoryInterface::class, EksekusiRepository::class);
        $this->app->bind(AccessDataRepositoryInterface::class, AccessDataRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
