<?php

class HtmlContentElement extends \ContentElement
{

    public static $singular_name = 'HTML';

    public static $plural_name = 'HTML';

    private static $db = array(
        'Content' => 'HTMLText'
    );


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $codeField = new \CodeEditorField('Content', 'Inhalt');
        $codeField->addExtraClass('stacked');
        $codeField->setRows(15);
        $codeField->setMode('html');
        $codeField->setTheme('twilight');
        $fields->addFieldToTab('Root.Main', $codeField);

        return $fields;
    }

    public function Preview()
    {
        return '';
    }

}