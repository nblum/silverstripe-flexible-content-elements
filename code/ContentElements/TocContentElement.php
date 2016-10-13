<?php

class TocContentElement extends \ContentElement
{
    public function Preview()
    {
        return '1. 2. 3. ...';
    }

    /**
     * creates a list of toc entries
     * @return ArrayList
     */
    public function toc()
    {
        $entries = $this->getSiblings();

        $toc = [];
        /* @var ContentElement $entry */
        foreach ($entries as $entry) {
            if ($this->getClassName() === $entry->getClassName()) {
                continue;
            }
            if (empty($entry->getTitle())) {
                continue;
            }
            $toc[] = new ArrayData([
                'Title' => $entry->getTitle(),
                'Identifier' => $entry->getReadableIdentifier()
            ]);
        }

        return new ArrayList($toc);
    }

}