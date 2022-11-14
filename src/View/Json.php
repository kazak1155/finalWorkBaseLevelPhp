<?php

namespace App\View;

/**
 * Class Json
 * @package App\View
 */
class Json implements Renderable
{
    private array $data;

    public function __construct( $data)
    {
        $this->data = $data;
    }

    public function render()
    {
        echo json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
}
