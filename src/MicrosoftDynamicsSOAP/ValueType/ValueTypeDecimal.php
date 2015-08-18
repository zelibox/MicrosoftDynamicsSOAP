<?php

namespace MicrosoftDynamicsSOAP\ValueType;


class ValueTypeDecimal extends AbstractValueType
{
    protected function createValueElement()
    {
        $elementValue = $this->document->createElement('b:value');
        $elementValue->setAttribute('i:type', 'c:decimal');
        $elementValue->setAttribute('xmlns:c', 'http://www.w3.org/2001/XMLSchema');

        return $elementValue;
    }

    protected function setValue($value)
    {
        $this->getValueNode()->nodeValue = $value;
    }
}