<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\Models\User;

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
        Gate::define('manage-obat', function (User $user) {
            return $user->role == 'admin'
                ? Response::allow()
                : Response::deny('Anda tidak memiliki akses mengelola bagian obat.');
        });

        Gate::define('manage-stok', function (User $user) {
            return ($user->role == 'admin' || $user->role == 'supplier')
                ? Response::allow()
                : Response::deny('Anda tidak memiliki akses mengelola bagian stok obat.');
        });

        Gate::define('manage-transaksi', function (User $user) {
            return ($user->role == 'admin' || $user->role == 'kasir' || $user->role == 'pelanggan')
                ? Response::allow()
                : Response::deny('Anda tidak memiliki akses mengelola transaksi.');
        });

        Gate::define('confirm-transaksi', function (User $user) {
            return ($user->role == 'admin' || $user->role == 'kasir')
                ? Response::allow()
                : Response::deny('Anda tidak memiliki akses mengonfirmasi transaksi.');
        });
    }
}
