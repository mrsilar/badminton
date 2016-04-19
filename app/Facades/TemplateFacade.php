<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TemplateFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'TemplateService';
    }

}
