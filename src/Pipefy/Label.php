<?php
namespace Pipefy\Pipefy;

use Pipefy\Pipefy\APIObject;

class Label extends APIObject {
    public $id;
    public $name;
    public $color;


    /**
     * @param null $data
     */
    function __construct($data = null) {
        if ($data != null) {
            $this->assign_results($data);
        }
    }
}