<?php

namespace MicrosoftDynamicsSOAP\ValueType;


class ValueTypeBoolean extends AbstractValueType
{
    /**
     * @return \DOMElement
     */
    protected function createValueElement()
    {
        $elementValue = $this->document->createElement('b:value');
        $elementValue->setAttribute('i:type', 'c:boolean');
        $elementValue->setAttribute('xmlns:c', 'http://www.w3.org/2001/XMLSchema');

        return $elementValue;
    }

    protected function setValue($value)
    {
        $this->getValueNode()->nodeValue = ($value) ? 'true' : 'false';
    }
}