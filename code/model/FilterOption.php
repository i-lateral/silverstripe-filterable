<?php

/**
 * Filter that can be added to an object
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class FilterOption extends DataObject {

    private static $db = array(
        'Title'         => 'Varchar',
        'Sort'          => 'Int'
    );

    private static $has_one = array(
        "Parent" => "FilterGroup"
    );

    private static $searchable_fields = array(
      'Title'       => array('title' => 'Title'),
      'Parent.Title'=> array('title' => 'Filter')
    );

    private static $summary_fields = array(
        'Title'         => 'Title',
        'ParentFilter'  => 'Filter'
    );

    private static $default_sort = "\"Sort\" DESC";


    /**
     * return the title of the parent filter
     *
     * @return string
     */
    public function getParentFilter() {
        return $this->Parent()->Title;
    }

    public function canView($member = false) {
        return $this->Parent()->canView($member);
    }

    public function canCreate($member = false) {
        return $this->Parent()->canCreate($member);
    }

    public function canEdit($member = false) {
        return $this->Parent()->canEdit($member);
    }

    public function canDelete($member = false) {
        return $this->Parent()->canDelete($member);
    }

}
