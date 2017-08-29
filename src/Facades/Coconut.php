<?php namespace CodyPChristian\Coconut\Facades;

use Illuminate\Support\Facades\Facade;

class Coconut extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {return 'coconut';}

}
