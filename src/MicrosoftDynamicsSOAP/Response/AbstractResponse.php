<?php

namespace MicrosoftDynamicsSOAP\Response;

abstract class AbstractResponse
{
    /** @var \DOMDocument  */
    private $XML;

    /**
     * @param $data string
     */
    public function __construct($data) {
        $document = new \DOMDocument();
        $document->formatOutput = true;
        $document->loadXML($data);

        $this->XML = $document;
    }

    /**
     * @return \DOMDocument
     */
    public function getXML() {
        return $this->XML;
    }
}