<?php

namespace Sirgrimorum\JSLocalization;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Blade;

class JSLocalizationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/jslocalization.php' => config_path('sirgrimorum/jslocalization.php'),
                ], 'config');

        Blade::directive('jslocalization', function($expression) {
            $auxExpression = explode(',', str_replace(['(', ')', ' ', '"', "'"], '', $expression));
            if (count($auxExpression)>2){
                $langfile=$auxExpression[0];
                $group=$auxExpression[1];
                $basevar=$auxExpression[2];
            } elseif (count($auxExpression)>1){
                $langfile=$auxExpression[0];
                $group=$auxExpression[1];
                $basevar = "";
            }else{
                $langfile=$auxExpression[0];
                $group="";
                $basevar = "";
            }
            $translations = new \Sirgrimorum\JSLocalization\BindTranslationsToJs($this->app, config('sirgrimorum.jslocalization.bind_trans_vars_to_this_view', 'layout.app'), config('sirgrimorum.jslocalization.trans_group', 'messages'), config('sirgrimorum.jslocalization.default_base_var', 'translations'));
            return $translations->get($langfile, $group, $basevar);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BindTranslationsToJs::class, function ($app) {
            $view = config('sirgrimorum.jslocalization.bind_trans_vars_to_this_view', 'welcome');
            $group = config('sirgrimorum.jslocalization.trans_group', 'mensajes');
            $basevar = config('sirgrimorum.jslocalization.default_base_var', 'translations');

            return new BindTranslationsToJs($app, $view, $group, $basevar);
        });
        $loader = AliasLoader::getInstance();
        $loader->alias(
                'JSLocalization', \Sirgrimorum\JSLocalization\BindTranslationsToJs::class
        );
        //$this->app->alias(BindTranslationsToJs::class, 'JSLocalization');
        $this->mergeConfigFrom(
                __DIR__ . '/Config/jslocalization.php', 'sirgrimorum.jslocalization'
        );
    }
}
