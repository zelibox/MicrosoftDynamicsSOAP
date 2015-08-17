# MicrosoftDynamicsSOAP
Microsoft Dynamics SOAP integration with PHP (http authentication)

##Example:
```php
$microsoftDynamicsSOAP = new \MicrosoftDynamicsSOAP\Connector(
    'ORG\Username',
    'password',
    'http://host.com/TEST/XRMServices/2011/Organization.svc/web'
);

$requestCreate = $microsoftDynamicsSOAP->createRequestCreate();
$requestCreate->setEntityName('phonecall');
$requestCreate->addValue('string', 'subject', 'New message');
$requestCreate->addValue('string', 'phonenumber', '900990099');
$requestCreate->addValue('boolean', 'is_active', false);
$requestCreate->addValue(
    'entity',
    'client',
    array(
        'logicalName' => 'client',
        'id' => 'A83C1811-9336-E511-9122-005056995950'
    )
);

$requestCreate->addValue('datetime', 'date_contact', new \DateTime());

$resp = $requestCreate->send();
```
