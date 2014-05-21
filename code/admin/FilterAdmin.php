<?php

/**
 * Interface for managing filters
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class FilterAdmin extends ModelAdmin {
    private static $url_segment = 'filters';

    private static $menu_title = 'Filters';

    private static $menu_priority = 2;

    private static $managed_models = array(
        'FilterGroup' => array('title' => 'Filters')
    );

    public $showImportForm = array('Product');

    public function init() {
        parent::init();
    }

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);
        $params = $this->request->requestVar('q');

        if($this->modelClass == 'FilterGroup') {
            $gridField = $form->Fields()->fieldByName('FilterGroup');
            $field_config = $gridField->getConfig();

            // Re add creation button and update grid field
            $add_button = new GridFieldAddNewButton('toolbar-header-left');
            $add_button->setButtonName(_t("Filterable.AddFilter","Add Filter"));

            $field_config
                ->removeComponentsByType('GridFieldExportButton')
                ->removeComponentsByType('GridFieldPrintButton')
                ->removeComponentsByType('GridFieldAddNewButton')
                ->addComponents(
                    $add_button,
                    GridFieldOrderableRows::create('Sort')
                );

        }

        return $form;
    }
}
