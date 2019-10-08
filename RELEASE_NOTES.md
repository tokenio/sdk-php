# Release 2.0.0
- Removes backwards compatibility with the old Token Request flow.
> A TokenRequestBuilder can no longer be constructed directly from a TokenPayload.
>Please set fields using the setters in `TokenRequestBuilder.php`. 

>The `addOption` and `addAllOptions` methods have been removed. Please use the
>setters for bank ID, source account ID, 'from' member, etc.

- Changes the `resolveAlias` method to return a `TokenMember` object containing member ID
and the full alias with the appropriate type, or null if the alias does not exist.
> For example, `if (resolveAlias(alias)) { ... }` might be rewritten as `if (!is_null(resolveAlias())) { ... }`.

- Adds support for standing orders and scheduled payments.
>To indicate that a transfer should be executed on a specific future date, use the
>`setExecutionDate` method in `TransferTokenRequestBuilder.php`. To construct a
>token request for a standing order, use `StandingOrderTokenRequestBuilder.php`.

- Changes the build_proto.rb script to recursively search through subdirectories for proto files.
 
# Release 1.0.0 (since 1.0.0-beta-3)
- Introduces new Token Request flow. `TokenRequest` consists of `TokenRequestPayload` 
(immutable fields) and `TokenRequestOptions` (mutable fields). It should no longer contain 
`TokenPayload`.
- Adds support for eIDAS certificates.
- Introduces `TransferDestination` object, which should be used for transfer destinations.
>TransferEndpoint is now deprecated as a transfer destination. (Though it can still be used 
as a transfer source.)
- Defaults `transferRefId` to `tokenRefId` if not set on token redemption.
- Removes address, trusted beneficiary APIs.
- Permits use of `TokenClient` without a developer key.
- Add samples/ file demonstrating common uses of the SDK.
- Sets the `token-sdk-version` header properly using the version in `composer.json`.