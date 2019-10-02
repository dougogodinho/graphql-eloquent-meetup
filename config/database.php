<?php

(function(){

    $capsule = new \Illuminate\Database\Capsule\Manager();
    $capsule->addConnection(['driver' => 'sqlite', 'database' => __DIR__ . '/../database.sqlite']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

})();
