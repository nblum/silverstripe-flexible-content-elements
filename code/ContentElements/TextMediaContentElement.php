<?php

class TextMediaContentElement extends ContentElement
{


    private static $db = array(
        'Orientation' => 'Varchar(16)',
        'Position' => 'Varchar(16)',
        'Width' => 'Int',
        'Height' => 'Int',
        'Click' => 'Varchar(64)',
        'Link' => 'LinkField',
        'Content' => 'HTMLText'
    );

    public static $has_one = array(
        'Image' => 'Image'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $urlSegment = $this->Parent()->getField('URLSegment');

        $fields->removeFieldsFromTab('Root.Main', [
            'Image',
            'Caption',
            'Orientation',
            'Position',
            'Width',
            'Height',
            'Click',
            'Link',
            'Content'
        ]);


        $content = HtmlEditorField::create('Content', _t('ContentElement.content.name'))
            ->setRows(25);

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

        $position = OptionsetField::create('Position', '', [
            'left' => _t('FCE.image.position.left'),
            'center' => _t('FCE.image.position.center'),
            'right' => _t('FCE.image.position.right')
        ], 'left');

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
        if(empty($this->getField('Link'))) {
            $link->setValue([
                'PageID' => $this->getField('ID')
            ]);
        }

        $fields->addFieldsToTab('Root.Main', [
            TabSet::create('Tabset',
                Tab::create(
                    'Copy',
                    $content
                ),
                Tab::create(
                    'Media',
                    $image,
                    $caption,
                    HeaderField::create(_t('FCE.image.orientation.title')),
                    $orientation,
                    $position,
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
                )
            )
        ]);

        return $fields;
    }
}