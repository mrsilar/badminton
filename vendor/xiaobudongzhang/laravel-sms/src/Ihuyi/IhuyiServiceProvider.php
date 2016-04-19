<?php
namespace Byz\LaravelSms\Ihuyi;

use Illuminate\Support\ServiceProvider;
use Byz\Sms\Ihuyi\Base;   //r
class IhuyiServiceProvider extends ServiceProvider
{

    /**
     * boot process
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/Config/config.php' => config_path('sms.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'sms');

        $this->app->bind('Ihuyi', function ($app) {
            $Ihuyi = new Base(
            	config('sms.ihuyi.host'),
            	config('sms.ihuyi.method'),
            	config('sms.ihuyi.user_name'),
            	config('sms.ihuyi.password')
            	);
            return $Ihuyi;
        }
        );
    }
}
