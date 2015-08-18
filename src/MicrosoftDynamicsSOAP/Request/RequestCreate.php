<?php

namespace MicrosoftDynamicsSOAP\Request;

class RequestCreate extends AbstractRequest
{
    /** @var  string */
    private $entityName = null;

    /** @var array */
    private $values = array();

    /**
     * @param $entityName string
     * @return $this
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;

        return $this;
    }

    public function addValue($type, $name, $value)
    {
        $this->values[] = array(
            'type' => $type,
            'name' => $name,
            'value' => $value
        );

        return $this;
    }

    protected function constructXML(\DOMDocument $XML)
    {
        $nodeBody = $XML->getElementsByTagName('s:Body')->item(0);
        $elementCreate = $XML->createElement('Create');
        $elementCreate->setAttribute('xmlns', 'http://schemas.microsoft.com/xrm/2011/Contracts/Services');
        $elementCreate->setAttribute('xmlns:i', 'http://www.w3.org/2001/XMLSchema-instance');
        $nodeCreate = $nodeBody->appendChild($elementCreate);

        $elementEntity = $XML->createElement('entity');
        $elementEntity->setAttribute('xmlns:a', 'http://schemas.microsoft.com/xrm/2011/Contracts');
        $nodeEntity = $nodeCreate->appendChild($elementEntity);

        $elementAttributes = $XML->createElement('a:Attributes');
        $elementAttributes->setAttribute('xmlns:b', 'http://schemas.datacontract.org/2004/07/System.Collections.Generic');
        $nodeAttributes = $nodeEntity->appendChild($elementAttributes);

        foreach ($this->values as $value) {
            $typeClassName = '\\MicrosoftDynamicsSOAP\\ValueType\\ValueType' . ucfirst($value['type']);
            if (!class_exists($typeClassName)) {
                throw new \Exception(sprintf('Type "%s" not found', $value['type']));
            }
            $elementKeyValue = $XML->createElement('a:KeyValuePairOfstringanyType');
            $nodeKeyValue = $nodeAttributes->appendChild($elementKeyValue);
            new $typeClassName($XML, $nodeKeyValue, $value['name'], $value['value']);
        }

        $elementEntityState = $XML->createElement('a:EntityState');
        $elementEntityState->setAttribute('i:nil', 'true');
        $nodeEntity->appendChild($elementEntityState);

        $elementFormattedValues = $XML->createElement('a:FormattedValues');
        $elementFormattedValues->setAttribute('xmlns:b', 'http://schemas.datacontract.org/2004/07/System.Collections.Generic');
        $nodeEntity->appendChild($elementFormattedValues);

        $elementId = $XML->createElement('a:Id', '00000000-0000-0000-0000-000000000000');
        $nodeEntity->appendChild($elementId);

        $elementLogicalName = $XML->createElement('a:LogicalName', $this->entityName);
        $nodeEntity->appendChild($elementLogicalName);

        $elementRelatedEntities = $XML->createElement('a:RelatedEntities');
        $elementRelatedEntities->setAttribute('xmlns:b', 'http://schemas.datacontract.org/2004/07/System.Collections.Generic');
        $nodeEntity->appendChild($elementRelatedEntities);
    }
}