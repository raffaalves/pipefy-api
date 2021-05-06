<?php
namespace Pipefy\Pipefy;

use Pipefy\Pipefy\APIObject;

class PhaseDetail extends APIObject
{
    public $id;
    public $duration;
    public $created_at;
    public $phase; // Phase
    public $connected_cards; // [Card]
    public $checklists; // [Checklist]
    public $field_values; // [FieldValue]
    public $automated_messages; // []
    public $comments; // [Comment]



    /**
     * @param null $data mixed
     */
    function __construct($data = null) {
        if ($data != null) {
            $this->assign_results($data);

            $this->parse_property("phase", "Phase");
            $this->parse_property("checklists", "Checklist");
        }
    }
}