<?php

class ImageGalleryContentElement extends ContentElement
{

    public static $many_many = array(
        'Images' => 'Image'
    );


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $urlSegment = $this->Parent()->getField('URLSegment');

        $image = \UploadField::create('Images', _t('ContentElement.image.name'))
            ->setFolderName('Uploads/' . $urlSegment)
            ->setAllowedExtensions(['jpg', 'png']);

        $fields->addFieldsToTab('Root.Main', [
            $image
        ]);

        return $fields;
    }
}