<?php

namespace Sirgrimorum\JSLocalization;

use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

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
     * Return the  JavaScript 
     * 
     *
     * @param $langfile String The language file to load
     * @param $group String The key in the file to load, use . for nesting
     * @param $basevar String The variable to put de data in javascript
     */
    public static function get($langfile, $group = "", $basevar = "") {
        if ($basevar == "") {
            $basevar = config('sirgrimorum.jslocalization.default_base_var', 'translations');
        }
        if ($group == "") {
            $group = config('sirgrimorum.jslocalization.trans_group', 'messages');
        }
        $lang = App::getLocale();
        $file = new Filesystem();
        $langPath = config("sirgrimorum.jslocalization.default_lang_path", 'resources/lang');
        $transP = $file->getRequire(base_path() . Str::start(Str::finish($langPath, '/'), '/') . $lang . '/' . $langfile . '.php');
        if ($group != "") {
            $trans = $transP[$group];
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
        return "<script>window.{$basevar} = window.{$basevar} || {};{$basevar}.{$langfile} = {$jsarray};</script>";
    }

    /**
     * Puth a model in a variable in JavaScript 
     * 
     *
     * @param Model $model The object to load
     * @param $variable string The name of the variable, if empty, get the object basename
     */
    public static function put($model, $variable = "") {
        if (is_object($model)) {
            if ($variable == "") {
                $variable = class_basename(get_class($model));
            }
            $jsarray = $model->toJson();
            return "<script>{$variable} = {$jsarray};</script>";
        }elseif (is_array($model)) {
            if ($variable == "") {
                $variable = "varArray";
            }
            $jsarray = json_encode($model);
            return "<script>{$variable} = {$jsarray};</script>";
        }else{
            return "<script>{$variable} = '';</script>";
        }
    }

}
