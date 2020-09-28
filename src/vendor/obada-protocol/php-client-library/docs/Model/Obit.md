# # Obit

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**obitDid** | **string** | OBADA decentralized identifier | 
**usn** | **string** | Universal serial number | 
**obitDidVersions** | **string[]** | Client generated things. First hash + last hash | 
**ownerDid** | **string** | Owner is the person/entity that owns the obit and the physical asset it represents. Format is a DID like did:obada:owner:1234. However in the current version only test numbers will be used. | 
**obdDid** | **string** | Future use. The OBD DID is formatted like did:obada:obd:1234, which represents a utility token tracking orders and proofs. | 
**obitStatus** | **string** | Represent available Obit statuses:   - FUNCTIONAL   - NON_FUNCTIONAL   - DISPOSED   - STOLEN   - DISABLED_BY_OWNER | 
**manufacturer** | **string** | Waiting more specific details from Rohi | 
**partNumber** | **string** | Manufacturer provided. In cases where no part number is provided for the product, use model, or the most specific ID available from the manufacturer. MWCN2LL/A (an iPhone 11 Pro, Silver, 256GB, model A2160) | 
**serialNumberHash** | **string** | Serial number hashed with sha256 hash function | 
**metadata** | **object[]** | Get description from Rohi | [optional] 
**docLinks** | **object[]** |  | [optional] 
**structuredData** | **object[]** |  | [optional] 
**modifiedAt** | [**\DateTime**](\DateTime.md) |  | [optional] 
**rootHash** | **string** | Hash calculated by SHA256 (previous Obit root hash + Obit data) | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)


