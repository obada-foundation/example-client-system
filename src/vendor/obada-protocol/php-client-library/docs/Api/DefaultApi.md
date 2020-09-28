# Obada\Client\DefaultApi

All URIs are relative to *https://dev.api.obada.io*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createObit**](DefaultApi.md#createObit) | **POST** /obits | 
[**removeObit**](DefaultApi.md#removeObit) | **DELETE** /obits/{obit_did}/remove | 
[**searchObits**](DefaultApi.md#searchObits) | **GET** /obits | 
[**showObit**](DefaultApi.md#showObit) | **GET** /obits/{obit_did} | 



## createObit

> createObit($new_obit)



Creates a new obit.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new Obada\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$new_obit = new \Obada\Client\Model\NewObit(); // \Obada\Client\Model\NewObit | 

try {
    $apiInstance->createObit($new_obit);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->createObit: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **new_obit** | [**\Obada\Client\Model\NewObit**](../Model/NewObit.md)|  | [optional]

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## removeObit

> removeObit($obit_did)



Changes Obit status to deleted/hidden

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new Obada\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$obit_did = did:obada:fe096095-e0f0-4918-9607-6567bd5756b5; // string | The given ObitDID argument

try {
    $apiInstance->removeObit($obit_did);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->removeObit: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **obit_did** | **string**| The given ObitDID argument |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## searchObits

> \Obada\Client\Model\InlineResponse200 searchObits($usn, $owner_did, $offset, $limit)



Search obits by given arguments.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new Obada\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$usn = some_usn; // string | Universal serial number
$owner_did = 'owner_did_example'; // string | OBADA owner DID
$offset = 0; // int | Number of records to skip for pagination.
$limit = 0; // int | Maximum number of records to return.

try {
    $result = $apiInstance->searchObits($usn, $owner_did, $offset, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->searchObits: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **usn** | **string**| Universal serial number | [optional]
 **owner_did** | **string**| OBADA owner DID | [optional]
 **offset** | **int**| Number of records to skip for pagination. | [optional] [default to 0]
 **limit** | **int**| Maximum number of records to return. | [optional] [default to 0]

### Return type

[**\Obada\Client\Model\InlineResponse200**](../Model/InlineResponse200.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## showObit

> showObit($obit_did)



Shows the information about single Obit by given ObitDID

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new Obada\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$obit_did = did:obada:fe096095-e0f0-4918-9607-6567bd5756b5; // string | The given ObitDID argument

try {
    $apiInstance->showObit($obit_did);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->showObit: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **obit_did** | **string**| The given ObitDID argument |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)

