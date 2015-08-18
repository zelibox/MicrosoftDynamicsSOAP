<?php

namespace MicrosoftDynamicsSOAP\ValueType;


class ValueTypeInt extends AbstractValueType
{
    protected function createValueElement()
    {
        $elementValue = $this->document->createElement('b:value');
        $elementValue->setAttribute('i:type', 'c:int');
        $elementValue->setAttribute('xmlns:c', 'http://www.w3.org/2001/XMLSchema');

        return $elementValue;
    }

    protected function setValue($value)
    {
        $this->getValueNode()->nodeValue = (int) $value;
    }
}