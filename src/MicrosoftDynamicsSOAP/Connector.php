<?php

namespace MicrosoftDynamicsSOAP;

/**
 * Class MicrosoftDynamicsSOAP
 * @package MicrosoftDynamicsSOAP
 */
class Connector
{
    /** @var string  */
    private $user;

    /** @var string  */
    private $password;

    /** @var string  */
    private $location;

    /**
     * @param $user string
     * @param $password string
     * @param $location string
     */
    function __construct($user, $password, $location)
    {
        $this->user = $user;
        $this->password = $password;
        $this->location = $location;
    }

    /**
     * @return Request\RequestCreate
     */
    public function createRequestCreate() {
        $request = new Request\RequestCreate($this);

        return $request;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
