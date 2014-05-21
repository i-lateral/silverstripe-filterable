<?php

/**
 * Add additional functionality to default admin panels
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class FilterableLeftAndMain extends LeftAndMainExtension {
    public function init() {
        parent::init();

        Requirements::css('filterable/css/admin.css');
    }
}
