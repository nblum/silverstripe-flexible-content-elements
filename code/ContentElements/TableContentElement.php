<?php

class TableContentElement extends \ContentElement
{

    private static $db = array(
        'Content' => 'HTMLText',
        'FirstRowIsHead' => 'Boolean'
    );


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();


        $fields->removeFieldsFromTab('Root.Main', [
            'Content',
            'FirstRowIsHead'
        ]);

        $firstRowIsHead = new \CheckboxField('FirstRowIsHead', _t('TableContentElement.FirstRowIsHead'));
        $fields->addFieldToTab('Root.Main', $firstRowIsHead);

        $tableField = new \TableField('Content');
        $fields->addFieldToTab('Root.Main', $tableField);

        return $fields;
    }

    public function Table()
    {
        $data = json_decode($this->getField('Content'), true);

        $table = [];
        foreach ($data as $index => $entry) {
            $columns = [];
            foreach ($entry as $colIndex => $column) {
                $columns[] = new ArrayData([
                    'Index' => $colIndex,
                    'Value' => $column
                ]);
            }

            $table[] = new ArrayData([
                'IsHead' => $index === 0 && $this->getField('FirstRowIsHead'),
                'Index' => $index,
                'Columns' => new ArrayList($columns)
            ]);
        }

        return new ArrayList($table);
    }

    public function Preview()
    {
        $data = json_decode($this->getField('Content'), true);

        return substr(implode(' | ', array_map(function ($entry) {
            return implode(',', $entry);
        }, $data)), 0, 20) . '...';
    }

}