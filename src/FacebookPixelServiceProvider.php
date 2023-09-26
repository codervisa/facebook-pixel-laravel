<?php

namespace Alilor\FacebookPixel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Class FacebookPixelServiceProvider
 * @package Alilor\FacebookPixel
 */
class FacebookPixelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'facebook-pixel');

        $this->publishes([
            __DIR__ . '/../resources/config/facebook-pixel.php' => config_path('facebook-pixel.php'),
        ], 'config');

        $this->app['view']->creator(
            ['facebook-pixel::head', 'facebook-pixel::body'],
            'Alilor\FacebookPixel\ScriptViewCreator'
        );
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        if (Schema::hasTable('alilor_plugins')) {
            // Plugins Facebook Pixel
            $plugin_facebook_pixel = DB::table('alilor_plugins')->where('name', 'facebook-pixel')->select('value')->first();
            if ($plugin_facebook_pixel !== null) {
                $facebook_pixel = json_decode($plugin_facebook_pixel->value, true);
                $enabled = $facebook_pixel['active'];
                $pixel_ids = $facebook_pixel['pixel_ids'];

                $FacebookPixel = new FacebookPixel($pixel_ids);

                if ($enabled === false) {
                    $FacebookPixel->disable();
                }

                $this->app->instance('Alilor\FacebookPixel\FacebookPixel', $FacebookPixel);
                $this->app->alias(FacebookPixel::class, 'facebook-pixel');
            }
        }
    }
}
