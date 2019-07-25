<?php namespace Sirgrimorum\JSLocalization;

use Illuminate\Support\Facades\Facade;

class JSLocalizationFacade extends Facade {

    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'JSLocalization';
    }

} 