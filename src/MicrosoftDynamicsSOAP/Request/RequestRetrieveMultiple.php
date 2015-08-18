<?php

namespace MicrosoftDynamicsSOAP\Request;

class RequestRetrieveMultiple extends AbstractRequest
{
    /** @var  string */
    private $entityName = null;

    /** @var array */
    private $columns = array();

    /** @var null|array */
    private $pageInfo = null;

    /**
     * @param $entityName string
     * @return $this
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function setPageInfo($pageNumber, $count)
    {
        $this->pageInfo = array(
            'pageNumber' => $pageNumber,
            'count' => $count,
        );
    }

    protected function constructXML(\DOMDocument $XML)
    {
        $nodeBody = $XML->getElementsByTagName('s:Body')->item(0);
        $elementRetrieveMultiple = $XML->createElement('RetrieveMultiple');
        $elementRetrieveMultiple->setAttribute('xmlns', 'http://schemas.microsoft.com/xrm/2011/Contracts/Services');
        $elementRetrieveMultiple->setAttribute('xmlns:i', 'http://www.w3.org/2001/XMLSchema-instance');
        $nodeRetrieveMultiple = $nodeBody->appendChild($elementRetrieveMultiple);

        $elementQuery = $XML->createElement('query');
        $elementQuery->setAttribute('i:type', 'a:FetchExpression');
        $elementQuery->setAttribute('xmlns:a', 'http://schemas.microsoft.com/xrm/2011/Contracts');
        $nodeQuery = $nodeRetrieveMultiple->appendChild($elementQuery);

        $nodeAQuery = $nodeQuery->appendChild($XML->createElement('a:Query'));

        $fetchDocument = new \DOMDocument();
        $elementFetch = $fetchDocument->createElement('fetch');
        $elementFetch->setAttribute('version', '1.0');
        $elementFetch->setAttribute('output-format', 'xml-platform');
        $elementFetch->setAttribute('mapping', 'logical');
        $elementFetch->setAttribute('distinct', 'false');
        if ($this->pageInfo) {
            $elementFetch->setAttribute('page', $this->pageInfo['pageNumber']);
            $elementFetch->setAttribute('count', $this->pageInfo['count']);
        }
        $nodeFetch = $fetchDocument->appendChild($elementFetch);

        $elementFetchEntity = $fetchDocument->createElement('entity');
        $elementFetchEntity->setAttribute('name', $this->entityName);
        $nodeFetchEntity = $nodeFetch->appendChild($elementFetchEntity);

        foreach ($this->columns as $column) {
            $elementFetchAttribute = $fetchDocument->createElement('attribute');
            $elementFetchAttribute->setAttribute('name', $column);
            $nodeFetchEntity->appendChild($elementFetchAttribute);
        }

        $nodeAQuery->nodeValue = htmlentities($fetchDocument->saveXML());
    }
}