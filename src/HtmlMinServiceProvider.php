<?php

namespace Fir\HtmlMin;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;

class HtmlMinServiceProvider extends ServiceProvider{

    public function register() {
        //开发模式下不启用
        if(!config('app.debug')){
            $this->MinifyCompiler($this->app);
        }
    }

    private function MinifyCompiler($app){
        $app->view->getEngineResolver()->register('blade.php', function () use ($app) {
            $cachePath = storage_path() . '/framework/views';
            $compiler = new HtmlMinifyCompiler($app['files'], $cachePath);
            return new CompilerEngine($compiler);
        });
        $app->view->addExtension('blade.php', 'blade.php');
    }

}
