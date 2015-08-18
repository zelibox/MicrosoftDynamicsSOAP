<?php

namespace MicrosoftDynamicsSOAP\ValueType;


class ValueTypeDatetime extends AbstractValueType
{
    /**
     * @return \DOMElement
     */
    protected function createValueElement()
    {
        $elementValue = $this->document->createElement('b:value');
        $elementValue->setAttribute('i:type', 'c:dateTime');
        $elementValue->setAttribute('xmlns:c', 'http://www.w3.org/2001/XMLSchema');

        return $elementValue;
    }

    protected function setValue($value)
    {
        if (!($value instanceof \DateTime)) {
            throw new \Exception ('Value must be instance of DateTime');
        }
        $this->getValueNode()->nodeValue = $value->format('Y-m-d\TH:i:s\Z');
    }

    public function getValue()
    {
        return new \DateTime(parent::getValue());
    }
}