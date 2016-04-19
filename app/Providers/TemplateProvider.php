<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TemplateProvider extends ServiceProvider
{
    /**
     * 指定是否延缓提供者加载。
     *
     * @var bool
     */
  //  protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('TemplateService', function ($app) {
            if ( ! isset($instance))
            {
                $rule=new \PHPTemplate\Rules\Classical();
                $compiler = new \PHPTemplate\Compiler( $rule);
                $instance =new \PHPTemplate\Template($compiler);
                return $instance;
            }
        });
    }
}
