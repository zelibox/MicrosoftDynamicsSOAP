<?php
/**
 * Created by PhpStorm.
 * User: Омельченко
 * Date: 17.08.2015
 * Time: 16:56
 */

namespace MicrosoftDynamicsSOAP\ValueType;


class ValueTypeEntity extends AbstractValueType
{
    /**
     * @return \DOMElement
     */
    protected function createValueElement()
    {
        $elementValue = $this->document->createElement('b:value');
        $elementValue->setAttribute('i:type', 'a:EntityReference');

        $elementId = $this->document->createElement('a:Id');
        $elementValue->appendChild($elementId);

        $elementLogicalName = $this->document->createElement('a:LogicalName');
        $elementValue->appendChild($elementLogicalName);

        $elementName = $this->document->createElement('a:Name');
        $elementName->setAttribute('i:nil', 'true');
        $elementValue->appendChild($elementName);

        return $elementValue;
    }

    protected function setValue($value)
    {
        $this->getValueNode()->childNodes->item(0)->nodeValue = $value['id'];
        $this->getValueNode()->childNodes->item(1)->nodeValue = $value['logicalName'];
    }

}