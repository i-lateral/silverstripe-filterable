<?php

class FilterableLeftAndMain extends LeftAndMainExtension {
    public function init() {
        parent::init();

        Requirements::css('filterable/css/admin.css');
    }
}
