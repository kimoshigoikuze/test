<?php /** @noinspection PhpIncludeInspection */

namespace Mvc;

class View
{
    public static function render($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__DIR__)) . '/build');
            $twig = new \Twig\Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}
