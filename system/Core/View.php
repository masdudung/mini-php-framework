<?php

namespace System\Core;

class View
{
    protected $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../app/Views');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false,
            // 'cache' => __DIR__ . '/../../storage/cache',
        ]);
    }

    public function render($view, $data = [])
    {
        echo $this->twig->render($view, $data);
    }
}
