<?php
namespace Pipefy\Pipefy;

use Pipefy\Pipefy\APIObject;

class CardPhaseDetail extends APIObject
{
    public $id;
    public $card_id;
    public $phase_id;
    public $card; // Card



    /**
     * @param null $data mixed
     */
    function __construct($data = null) {
        if ($data != null) {
            $this->assign_results($data);
        }
    }
}