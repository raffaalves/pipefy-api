<?php
namespace Pipefy;

use Pipefy\APIObject;

class Field extends APIObject {
    public $id;
    public $phase_id;
    public $label;
    public $default_value;
    public $type_id;
    public $index;
    public $options; // [],
    public $created_at;
    public $updated_at;


    /**
     * @param null $data
     */
    function __construct($data = null) {
        if ($data != null) {
            $this->assign_results($data);
        }
    }


    /**
     * @param null $field_id int
     * @return $this
     */
    public function fetch($field_id = null) {
        if ($field_id == null)
            $field_id = $this->id;

        $resp = $this->send_get("https://app.pipefy.com/fields/$field_id.json", null, null);
        $this->assign_results($resp);

        return $this;
    }
}