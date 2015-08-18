<?php

namespace MicrosoftDynamicsSOAP\Response;

use MicrosoftDynamicsSOAP\ValueType\AbstractValueType;

class Entity
{
    /** @var array */
    private $values;

    public function __construct(\DOMDocument $XML, \DOMElement $element)
    {
        $this->values = array();

        /** @var \DOMElement $elementAttributes */
        $elementAttributes = $element->getElementsByTagName('Attributes')->item(0);

        /** @var \DOMElement $elementKeyValue */
        foreach ($elementAttributes->getElementsByTagName('KeyValuePairOfstringanyType') as $elementKeyValue) {
            $key = $elementKeyValue->getElementsByTagName('key')->item(0)->nodeValue;
            /** @var \DOMElement $elementValue */
            $elementValue = $elementKeyValue->getElementsByTagName('value')->item(0);
            $type = explode(':', $elementValue->getAttribute('i:type'))[1];
            $typeClassName = '\\MicrosoftDynamicsSOAP\\ValueType\\ValueType' . ucfirst($type);
            if (!class_exists($typeClassName)) {
                throw new \Exception(sprintf('Type "%s" not found', $type));
            }
            /** @var AbstractValueType $valueType */
            $valueType = new $typeClassName($XML, $elementKeyValue);
            $this->values[$key] = $valueType->getValue();
        }
    }

    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getValue($key)
    {
        return (isset($this->values[$key])) ? $this->values[$key] : null;
    }
}