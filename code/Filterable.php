<?php

/**
 * Core class for working with the filterable module.
 *
 * Filterable adds a many_many relationship to the dataobject required
 * and then adds a belongs_many_many back to the FilterOption object.
 *
 * Doing this will create a relationship on your DataObject called
 * "Filters"
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class Filterable extends Object {

    /**
     * Adds filterable to a {@link DataObject}.
     *
     * @param string classname to add filters to
     * @param string relation to add to FilterOption object
     */
    public static function add($class, $relation) {
        // Update the many many relations on
        $belongs = (is_array(FilterOption::config()->belongs_many_many)) ? FilterOption::config()->belongs_many_many : array();
        $belongs[$relation] = $class;
        FilterOption::config()->belongs_many_many = $belongs;

        $class::add_extension('FilterableObject');
    }

    /**
     * Removes filtering from a {@link DataObject}. Does not remove
     * existing relations but does remove the extension.
     *
     * @param string classname to remove filters from
     * @param string relation to be removed from FilterOption object
     */
    public static function remove($class, $relation) {
        // Update the many many relations on
        $belongs = (is_array(FilterOption::config()->belongs_many_many)) ? FilterOption::config()->belongs_many_many : array();

        if(isset(self::$belongs["Filters"])) {
            unset(self::$belongs["Filters"]);
        }

        FilterOption::config()->belongs_many_many = $belongs;

        $class::remove_extension('FilterableObject');
    }

}
