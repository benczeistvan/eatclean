<?php
spl_autoload_register(function ($class) {
    include 'src/' . $class . '.php';
});

ob_start();
$app = new App();
$app->renderPage();

ob_get_flush();
