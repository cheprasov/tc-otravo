<?php

namespace TC\Otravo;

spl_autoload_register(
    function($className) {
        if (0 !== strpos($className, __NAMESPACE__ . '\\')) {
            return;
        }
        $classPath = __DIR__ . '/' . str_replace('\\', '/', substr($className, strlen(__NAMESPACE__) + 1)) . '.php';
        if (file_exists($classPath)) {
            include $classPath;
        }
    }
);
