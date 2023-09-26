<?php

namespace Alilor\FacebookPixel;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelFacebookPixelFacade
 * @package Alilor\LaravelFacebookPixel
 */
class FacebookPixelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'facebook-pixel';
    }
}
