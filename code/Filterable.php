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
class Filterable extends Object implements PermissionProvider {

    /**
     * List of class names that have beern made filterable. This can
     * be usefull if you need to find out a list of what objects are
     * available for filtering.
     *
     * @var array
     */
    private static $filtered_classes = array();

    public static function getFilteredClasses() {
        return self::$filtered_classes;
    }

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

        // Add classname to list of filtered classes
        self::$filtered_classes[] = $class;

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

        // Remove our relation
        if(isset($belongs["Filters"]))
            unset($belongs["Filters"]);

        // Now remove the class from our list of classes
        if(isset(self::$filtered_classes[$class]))
            unset(self::$filtered_classes[$class]);

        FilterOption::config()->belongs_many_many = $belongs;

        $class::remove_extension('FilterableObject');
    }

    /**
     * Add permissions to allow editing and deleting of filters
     *
     */
    public function providePermissions() {
        return array(
            "FILTERABLE_ADD" => array(
                'name' => 'Add filters',
                'help' => 'Allow adding of custom filters',
                'category' => 'Filterable',
                'sort' => 100
            ),
            "FILTERABLE_EDIT" => array(
                'name' => 'Edit filters',
                'help' => 'Allow editing of custom filters',
                'category' => 'Filterable',
                'sort' => 100
            ),
            "FILTERABLE_DELETE" => array(
                'name' => 'Delete filters',
                'help' => 'Allow deleting of custom filters',
                'category' => 'Filterable',
                'sort' => 100
            )
        );
    }

}
