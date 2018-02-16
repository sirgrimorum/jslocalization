<?php

namespace Sirgrimorum\JSLocalization;

use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Exception;

class BindTranslationsToJs {

    /**
     * @var Dispatcher
     */
    private $event;

    /**
     * @var string
     */
    private $viewToBind;

    /**
     * @var string
     */
    private $group;

    /**
     * @var string
     */
    private $app;

    /**
     * @var string
     */
    private $basevar;

    /**
     * @param Dispatcher $event
     * @param $viewToBindVariables
     */
    function __construct($app, $viewToBind, $group, $basevar) {
        $this->event = $app['events'];
        $this->viewToBind = $viewToBind;
        $this->app = $app;
        $this->basevar = $basevar;
        if ($group == "") {
            $this->group = "";
        } else {
            $this->group = $group;
        }
        //echo "<p>Construct</p>";
        //echo "<pre>" . print_r(["viewToBind"=>$this->viewToBind,"group"=>$this->group,"basevar"=>$this->basevar] , true) . "</pre>";
    }

    /**
     * Bind the given JavaScript to the
     * view using Laravel event listeners
     *
     * @param $langfile The language file to load
     */
    public function put($langfile) {
        $lang = $this->app->getLocale();
        $file = new Filesystem();
        $langPath = config("sirgrimorum.jslocalization.default_lang_path");
        $transP = $file->getRequire(base_path() . str_start(str_finish($langPath,'/'),'/') . $lang . '/' . $langfile . '.php');
        if ($this->group != "") {
            $trans = $transP[$this->group];
        } else {
            $trans = $transP;
        }
        //$translator = new Translator();
        //$trans = $translator->get($langfile . $this->group);
        if (is_array($trans)) {
            $jsarray = json_encode($trans);
        } else {
            $jsarray = $trans;
        }
        $this->event->listen("composing: {$this->viewToBind}", function() use ($jsarray, $langfile) {
            echo "<script>window.{$this->basevar} = window.{$this->basevar} || {};{$this->basevar}.{$langfile} = {$jsarray};</script>";
        });
    }

    /**
     * Return the  JavaScript 
     * 
     *
     * @param $langfile The language file to load
     * @param $group The key in the file to load use . for nesting
     */
    public function get($langfile, $group = "") {
        $lang = $this->app->getLocale();
        $file = new Filesystem();
        $langPath = config("sirgrimorum.jslocalization.default_lang_path");
        $transP = $file->getRequire(base_path() . str_start(str_finish($langPath,'/'),'/') . $lang . '/' . $langfile . '.php');
        if ($group != "") {
            $trans = $transP[$group];
        } elseif ($this->group != "") {
            $trans = $transP[$this->group];
        } else {
            $trans = $transP;
        }
        //$translator = new Translator();
        //$trans = $translator->get($langfile . $this->group);
        if (is_array($trans)) {
            $jsarray = json_encode($trans);
        } else {
            $jsarray = $trans;
        }
        return "<script>window.{$this->basevar} = window.{$this->basevar} || {};{$this->basevar}.{$langfile} = {$jsarray};</script>";
    }

}
