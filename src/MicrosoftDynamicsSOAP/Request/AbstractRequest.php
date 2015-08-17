<?php

namespace MicrosoftDynamicsSOAP\Request;

use \MicrosoftDynamicsSOAP\Connector;

abstract class AbstractRequest
{
    /** @var Connector */
    protected $connector;

    /** @var \DOMDocument */
    private $XML;


    final public function __construct(Connector $connector)
    {
        $this->connector = $connector;

        $xml = new \DomDocument('1.0', 'utf-8');
        $elementEnvelope = $xml->createElement('s:Envelope');
        $elementEnvelope->setAttribute('xmlns:s', 'http://schemas.xmlsoap.org/soap/envelope/');
        $nodeEnvelope = $xml->appendChild($elementEnvelope);
        $nodeEnvelope->appendChild($xml->createElement('s:Body'));
        $xml->formatOutput = true;
        $this->XML = $xml;
    }

    protected function getActionSOAP()
    {
        $nameRequest = substr(strrchr(get_called_class(), "\\"), 1);
        $nameRequest = substr($nameRequest, 7);
        return 'http://schemas.microsoft.com/xrm/2011/Contracts/Services/IOrganizationService/' . $nameRequest;
    }

    public function send()
    {
        $headers = array(
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: text/xml; charset=utf-8',
            'SOAPAction: "' . $this->getActionSOAP() . '"'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->connector->getLocation());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getData());
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $this->connector->getUser() . ':' . $this->connector->getPassword());
        $response = curl_exec($ch);

        return $response;
    }

    /**
     * @return \DOMDocument
     */
    public function getXML()
    {
        return $this->XML;
    }

    private function getData()
    {
        $this->constructXML($this->getXML());
        return $this->XML->saveXML();
    }

    abstract protected function constructXML(\DOMDocument $XML);
}

