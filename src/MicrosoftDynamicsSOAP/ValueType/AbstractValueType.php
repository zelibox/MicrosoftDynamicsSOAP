<?php


namespace MicrosoftDynamicsSOAP\ValueType;


abstract class AbstractValueType
{
    /** @var \DOMDocument */
    protected $document;

    /** @var \DOMElement  */
    protected $elementXML;

    final public function __construct(\DOMDocument $document, \DOMElement $elementXML, $name = null, $value = null)
    {
        $this->document = $document;
        $this->elementXML = $elementXML;
        if($name !== null && $value !== null) {
            $this->setName($name);
            $this->setValue($value);
        }
    }

    /**
     * @return \DOMNode
     */
    protected function getKeyNode()
    {
        if(!$this->elementXML->getElementsByTagName('b:key')->length) {
            $elementKey = $this->document->createElement('b:key');
            $nodeKey = $this->elementXML->appendChild($elementKey);
        } else {
            $nodeKey =  $this->elementXML->getElementsByTagName('b:key')->item(0);
        }

        return $nodeKey;
    }

    /**
     * @return \DOMNode
     */
    protected function getValueNode()
    {
        if(!$this->elementXML->getElementsByTagName('b:value')->length) {
            $elementValue = $this->createValueElement();
            $nodeValue = $this->elementXML->appendChild($elementValue);
        } else {
            $nodeValue =  $this->elementXML->getElementsByTagName('b:value')->item(0);
        }

        return $nodeValue;
    }

    protected function setName($name)
    {
        $this->getKeyNode()->nodeValue = $name;
    }

    /**
     * @return \DOMElement
     */
    abstract protected function createValueElement();

    abstract protected function setValue($value);

    public function getElementXML()
    {
        return $this->elementXML;
    }
}