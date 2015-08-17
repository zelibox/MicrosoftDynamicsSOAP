<?php

namespace MicrosoftDynamicsSOAP\ValueType;


class ValueTypeString extends AbstractValueType
{
    protected function setValue($value)
    {
        $this->getValueNode()->nodeValue = $value;
    }

    /**
     * @return \DOMElement
     */
    protected function createValueElement()
    {
        $elementValue = $this->document->createElement('b:value');
        $elementValue->setAttribute('i:type', 'c:string');
        $elementValue->setAttribute('xmlns:c', 'http://www.w3.org/2001/XMLSchema');

        return $elementValue;
    }
}