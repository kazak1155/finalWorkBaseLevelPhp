<?php

namespace App\View;

/**
 * Class View
 * @package App\View
 */
class View implements Renderable
{

    private string $view;
    private array $data;

    public function __construct($view, $data)
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        extract($this->data);
        include  $this->getIncludeTemplate($this->view);
    }

    private function getIncludeTemplate($view)
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);
        $path = APP_DIR . VIEW_DIR . $view . '.php';
        return $path;
    }
}


