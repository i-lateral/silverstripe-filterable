<?php

/**
 * Filter that can be added to an object
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class FilterOption extends DataObject
{

    private static $db = array(
        "Title"         => "Varchar",
        "URLSegment"    => "Varchar",
        "Sort"          => "Int"
    );

    private static $has_one = array(
        "Parent" => "FilterGroup"
    );

    private static $searchable_fields = array(
      "Title"       => array("title" => "Title"),
      "Parent.Title"=> array("title" => "Filter")
    );

    private static $summary_fields = array(
        "Title"         => "Title",
        "URLSegment"    => "URL Segment",
        "ParentFilter"  => "Filter"
    );

    private static $default_sort = "\"Sort\" DESC";

    /**
     * Get a filter link for the current option, assuming the current
     * controller has the filterby action available
     *
     * @return string
     */
    public function Link()
    {
        $controller = Controller::curr();

        $link = $controller->Link("filterby");

        return $link . "?filter={$this->Parent()->URLSegment}:{$this->URLSegment}";
    }

    /**
     * return the title of the parent filter
     *
     * @return string
     */
    public function getParentFilter()
    {
        return $this->Parent()->Title;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        // Set our URL segment
        if (!$this->URLSegment) {
            $url = Convert::raw2url($this->Title);
            $url = str_replace(":", "", $url);
            $url = str_replace(";", "", $url);
            $this->URLSegment = $url;
        }
    }

    public function canView($member = false)
    {
        return $this->Parent()->canView($member);
    }

    public function canCreate($member = false)
    {
        return $this->Parent()->canCreate($member);
    }

    public function canEdit($member = false)
    {
        return $this->Parent()->canEdit($member);
    }

    public function canDelete($member = false)
    {
        return $this->Parent()->canDelete($member);
    }
}
