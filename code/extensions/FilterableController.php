<?php

/**
 * Adds filterby action to a standard controller and pulls in a list of
 * items to be filtered.
 *
 * By default, filterable will find all objects that need filtering
 * merge them and return an ArrayList of items
 *
 * The intention of this is to allow people to develop their own custom
 * filters to their own controllers that add additional features beyond
 * what this action provides.
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class FilterableController extends Extension {

    private static $allowed_actions = array(
        "filterby"
    );

    public function filterby() {
        // Get a list of filterable classes
        $classes = Filterable::getFilteredClasses();
        $results = ArrayList::create();
        $get_vars = $this->owner->request->getVars();
        $filter_ids = array();

        if(isset($get_vars["filter"])) {
            // First trim uneeded characters from string
            $filter_vars = trim($get_vars["filter"]," :;\t\n\r\0\x0B");

            // Now explode the filters stored in our filter var
            $filter_vars = explode(";", $filter_vars);

            // Now get the filter options we need to filter objects by
            foreach($filter_vars as $single_var) {
                $key_value = explode(":", $single_var);

                $filter_option = FilterOption::get()
                    ->filter(array(
                        "Parent.URLSegment:nocase" => $key_value[0],
                        "URLSegment:nocase" => $key_value[1]
                    ))->first();

                if($filter_option && $results->exists()) {
                    foreach($results as $result) {
                        if(!$result->Filters()->find("ID",$filter_option->ID)) {
                            $results->remove($result);
                        }
                    }
                } elseif($filter_option) {
                    foreach($classes as $class) {
                        $list = $class::get()
                            ->filter("Filters.ID:ExactMatch",$filter_option->ID);

                        if($list->exists())
                            $results->merge($list);
                    }
                }
            }
        }

        $results = new PaginatedList($results, $this->owner->request);

        $data = array(
            'Results' => $results
        );

        $this->owner->extend("updateFilterBy", $data);

        return $this
            ->owner
            ->customise($data)
            ->renderWith(array(
                'Page_filterby',
                'FilterBy',
                'Page'
            ));
    }
}
