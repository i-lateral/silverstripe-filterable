<?php

/**
 * Holder for filters that can then be added to objects
 *
 * @author i-lateral (http://www.i-lateral.com)
 * @package Filterable
 */
class FilterGroup extends DataObject {
    private static $db = array(
        "Title"         => "Varchar",
        "URLSegment"    => "Varchar",
        "Sort"          => "Int"
    );

    private static $has_many = array(
        "Options" => "FilterOption"
    );

    private static $summary_fields = array(
        "Title"         => "Title",
        "Options.count" => "#Options"
    );

    private static $default_sort = "\"Sort\" DESC";

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->removeByName('Sort');
        $fields->removeByName('Options');

        // Deal with product features
        $add_button = new GridFieldAddNewInlineButton('toolbar-header-left');
        $add_button->setTitle(_t("Filterable.AddOption","Add Option"));

        $options_field = new GridField(
            'Options',
            '',
            $this->Options(),
            GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent($add_button)
                ->addComponent(new GridFieldOrderableRows('Sort'))
        );

        // Add fields to the CMS
        $fields->addFieldToTab('Root.Main', TextField::create('Title'));
        $fields->addFieldToTab('Root.Main', TextField::create('URLSegment'));
        $fields->addFieldToTab("Root.Main", HeaderField::create("OptionsHeader", "Options available to this filter"));
        $fields->addFieldToTab('Root.Main', $options_field);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function onBeforeDelete() {
        parent::onBeforeDelete();

        foreach($this->Options() as $option) {
            $option->delete();
        }
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();

        // Set our URL segment
        if(!$this->URLSegment) {
            $url = Convert::raw2url($this->Title);
            $url = str_replace(":","",$url);
            $url = str_replace(";","",$url);
            $this->URLSegment = $url;
        }

    }

    public function canView($member = false) {
        return true;
    }

    public function canCreate($member = false) {
        if(!$member) $member = Member::currentUser();

        if($member && Permission::checkMember($member,"FILTERABLE_ADD"))
            return true;
        else
            return false;
    }

    public function canEdit($member = false) {
        if(!$member) $member = Member::currentUser();

        if($member && Permission::checkMember($member,"FILTERABLE_EDIT"))
            return true;
        else
            return false;
    }

    public function canDelete($member = false) {
        if(!$member) $member = Member::currentUser();

        if($member && Permission::checkMember($member,"FILTERABLE_DELETE"))
            return true;
        else
            return false;
    }
}
