# php-sdk

## Installation

To install the bindings via Composer, add the following to composer.json:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/obada-protocol/php-sdk.git"
    }
  ],
  "require": {
    "obada-protocol/php-sdk": "*@dev"
  }
}
````

Then run composer install

## Basic functionality

```php
    try {
        // Create a new Obit
        $obit = Obada\Obit::make([
            'serial_number_hash' => hash('sha256', 'SN123456'),
            'part_number'        => 'PN123456',
            'manufacturer'       => 'Sony',
        ]);

        // Get a root hash
        echo $obit->rootHash();

        // Get USN
        echo $obit->obitId->toUsn();
        
        // Get DID
        echo $obit->obitId->toDid();
    } catch (\Obada\Exceptions\PropertyValidationException $t) {
        // Handle validation errors
        echo $t->getMessage();
    } catch (Throwable $t) {
        // Other errors
    }
```

## Using ObitId API separately from Obit 

```php
    try {
        $obitId = new \Obada\Properties\ObitId::make([
            'serial_number_hash' => hash('sha256', 'SN123456'),
            'part_number'        => 'PN123456',
            'manufacturer'       => 'Sony',
        ]);
    
        // Check if ObitId is valid and pass integrity checks
        $obitId->isValid();
    
        // Get Usn
        $obitId->toUsn();
    
        // Get obitId hash
        $obitId->toHash();
    
        // Get obitId decentralized identifier
        $obitId->toDid();
    } catch (\Obada\Exceptions\PropertyValidationException $t) {
        // Handle validation errors
        echo $t->getMessage();
    } catch (Throwable $t) {
        // Handle other errors
    }
```

## Mappers

Converting Obit to rest api payload:

```php
// Create a new Obit
$obit = Obada\Obit::make([
    'serial_number_hash' => hash('sha256', 'SN123456'),
    'part_number'        => 'PN123456',
    'manufacturer'       => 'Sony',
]);

// Convert obit to gateway API payload
$obit = (new \Obada\Mappers\Output\Api\ObitMapper)->map($obit);

$apiInstance = new Obada\Api\ObitApi();

try {
    $apiInstance->createObit($obit);
} catch (Exception $e) {
    echo 'Exception when calling ObitApi->createObit: ', $e->getMessage(), PHP_EOL;
}
```

