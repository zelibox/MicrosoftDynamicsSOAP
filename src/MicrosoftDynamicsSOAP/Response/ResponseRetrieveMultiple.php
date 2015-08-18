<?php

namespace MicrosoftDynamicsSOAP\Response;

class ResponseRetrieveMultiple extends AbstractResponse
{
    /** @var  array */
    private $entities = array();

    public function getEntities()
    {
        if (count($this->entities)) {
            return $this->entities;
        }

        /** @var \DOMElement $entity */
        foreach ($this->getXML()->getElementsByTagName('Entity') as $entity) {
            $this->entities[] = new Entity($this->getXML(), $entity);
        }

        return $this->entities;
    }
}