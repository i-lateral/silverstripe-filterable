<?php

/**
 * Main extension class for dataobjects
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class FilterableObject extends DataExtension {

    static $many_many = array(
        "Filters" => "FilterOption"
    );

    function updateCMSFields(FieldList $fields) {
        $gridfield = $fields->dataFieldByName("Filters");

        if($gridfield) {
            $gridfield
                ->getConfig()
                ->getComponentsByType("GridFieldAddExistingAutocompleter")
                ->first();
        }
    }
}
