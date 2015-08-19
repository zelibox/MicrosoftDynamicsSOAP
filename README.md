# MicrosoftDynamicsSOAP
Microsoft Dynamics SOAP integration with PHP (http authentication)

##Connect:
```php
$microsoftDynamicsSOAP = new \MicrosoftDynamicsSOAP\Connector(
    'ORG\Username',
    'password',
    'http://host.com/TEST/XRMServices/2011/Organization.svc/web'
);
```

##Example Create:
```php
$requestCreate = $microsoftDynamicsSOAP->createRequestCreate();
$requestCreate
    ->setEntityName('phonecall');
    ->addValue('string', 'subject', 'New message')
    ->addValue('string', 'phonenumber', '900990099')
    ->addValue('boolean', 'is_active', false)
    ->addValue(
        'entityReference',
        'client',
        array(
            'logicalName' => 'client',
            'id' => 'A83C1811-9336-E511-9122-005056995950'
        )
    )
    ->addValue('datetime', 'date_contact', new \DateTime());
    
/** @var ResponseCreate $response */
$response = $requestCreate->send();

echo $response->getGuid();
```

##Example RetrieveMultiple:
```php
$requestRetrieveMultiple = $microsoftDynamicsSOAP->createRequestRetrieveMultiple();
$requestRetrieveMultiple
    ->setEntityName('lead')
    ->setColumns(array( // not required
        'subject',
        'phonenumber'
    ));

/** @var ResponseRetrieveMultiple $response */
$response = $requestRetrieveMultiple->send();

var_dump($response->getEntities());
```
