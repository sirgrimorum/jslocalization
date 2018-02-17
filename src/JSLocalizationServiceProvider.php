<?php

namespace sirgrimorum\JSLocalization;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Sirgrimorum\JSLocalization\BindTranslationsToJs;

class JSLocalizationServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            __DIR__ . '/Config/jslocalization.php' => config_path('sirgrimorum/jslocalization.php'),
                ], 'config');

        Blade::directive('translation_get', function($expression) {
            list($langfile, $group) = explode(',', str_replace(['(', ')', ' ', '"', "'"], '', $expression));
            $translations = new \Sirgrimorum\Cms\Translations\BindTranslationsToJs($this->app, config('sirgrimorum_cms.bind_trans_vars_to_this_view', 'welcome'), config('sirgrimorum_cms.trans_group', 'mensajes'), config('sirgrimorum_cms.default_base_var', 'translations'));
            return $translations->get($langfile, $group);
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {
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
