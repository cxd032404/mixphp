<?php

// web入口文件

require __DIR__ . '/../../../vendor/autoload.php';
die("here");
Mix::loadEnvironmentFrom(__DIR__ . '/../../../.env');
$config = require __DIR__ . '/../config/main_compatible.php';
(new Mix\Http\Application($config))->run();
