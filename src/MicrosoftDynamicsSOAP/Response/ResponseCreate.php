<?php

namespace MicrosoftDynamicsSOAP\Response;

class ResponseCreate extends AbstractResponse
{
    /**
     * @return null|string
     */
    public function getGuid()
    {
        if($this->getXML()->getElementsByTagName('CreateResult')->length) {
            return $this->getXML()->getElementsByTagName('CreateResult')->item(0)->nodeValue;
        }

        return null;
    }
}