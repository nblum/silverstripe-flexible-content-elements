<?php

class CustomizableImageContentElement extends ImageContentElement
{


    private static $db = array(
        'Orientation' => 'Varchar(64)',
        'Width' => 'Int',
        'Height' => 'Int',
        'Click' => 'Varchar(64)',
        'Link' => 'LinkField'
    );


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $urlSegment = $this->Parent()->getField('URLSegment');

        $fields->removeFieldsFromTab('Root.Main', [
            'Image',
            'Caption',
            'Orientation',
            'Width',
            'Height',
            'Click',
            'Link'
        ]);

        $image = \UploadField::create('Image', _t('ContentElement.image.name'))
            ->setAllowedMaxFileNumber(1)
            ->setFolderName('Uploads/' . $urlSegment)
            ->setAllowedExtensions(['jpg', 'png']);

        $caption = \TextareaField::create('Caption', _t('ContentElement.image.caption'))
            ->setRows(5);

        $orientation = OptionsetField::create('Orientation', '', [
            'original' => _t('FCE.image.orientation.original'),
            'landscape' => _t('FCE.image.orientation.landscape'),
            'portrait' => _t('FCE.image.orientation.portrait'),
            'cropped' => _t('FCE.image.orientation.cropped'),
        ], 'original');

        $width = NumericField::create('Width', _t('FCE.image.size.width'))
            ->setMaxLength(5);

        $height = NumericField::create('Height', _t('FCE.image.size.height'))
            ->setMaxLength(5);

        $clickAction = OptionsetField::create('Click', _t('FCE.image.click.title'), [
            'nothing' => _t('FCE.image.click.nothing'),
            'modal' => _t('FCE.image.click.modal'),
            'link' => _t('FCE.image.click.link')
        ], 'nothing');

        $link = LinkFormField::create('Link', _t('FCE.image.link.title'));

        $fields->addFieldsToTab('Root.Main', [
            $image,
            $caption,
            HeaderField::create(_t('FCE.image.orientation.title')),
            $orientation,
            DisplayLogicWrapper::create(
                HeaderField::create(_t('FCE.image.size.title')),
                $width
                    ->displayIf('Orientation')->isNotEqualTo('portrait')
                    ->end(),
                $height
                    ->displayIf('Orientation')->isNotEqualTo('landscape')
                    ->end()
            )
                ->displayIf('Orientation')->isNotEqualTo('original')
                ->end(),
            HeaderField::create(_t('FCE.image.click.title')),
            $clickAction,

            DisplayLogicWrapper::create(
                $link
            )
                ->displayIf('Click')->isEqualTo('link')
                ->end()
        ]);

        return $fields;
    }
}