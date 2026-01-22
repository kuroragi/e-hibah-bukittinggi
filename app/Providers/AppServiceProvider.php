<?php

namespace App\Providers;

use App\Models\Permohonan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        View::composer('*', function($view){
            $permohonanCounts = [
                'review_permohonan' => Permohonan::where('id_status', 4)->orWhere('id_status', 10)->count(),
                'confirm_permohonan' => Permohonan::where('id_status', 6)->orWhere('id_status', 12)->count(),
                'review_nphd' => Permohonan::where('id_status', 7)->count(),
            ];
            $view->with('permohonanCounts', $permohonanCounts);
        });
        Blade::directive('status_buttons', function($expression){
            return "<?php echo view('components.status_buttons', ['json' => $expression])->render(); ?>";
        });
        Blade::directive('action_buttons', function($expression){
            return "<?php echo view('components.action_buttons', ['json' => $expression])->render(); ?>";
        });
    }
}
