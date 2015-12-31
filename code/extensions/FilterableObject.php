<?php

/**
 * Main extension class for dataobjects
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class FilterableObject extends DataExtension
{

    public static $many_many = array(
        "Filters" => "FilterOption"
    );

    public function updateCMSFields(FieldList $fields)
    {
    }
}
