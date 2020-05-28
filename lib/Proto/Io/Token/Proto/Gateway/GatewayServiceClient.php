<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Io\Token\Proto\Gateway;

/**
 * //////////////////////////////////////////////////////////////////////////////////////////////////
 * Gateway Service.
 *
 */
class GatewayServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Member registration, key and alias management.
     *
     *
     * Create a member. Mints a member ID; newly-created member does not yet
     * have keys, alias, or anything other than an ID.
     * Used by createMember, https://developer.token.io/sdk/#create-a-member
     * (SDK's createMember also uses UpdateMember rpc).
     * @param \Io\Token\Proto\Gateway\CreateMemberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateMember(\Io\Token\Proto\Gateway\CreateMemberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateMember',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateMemberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a business member under realm of a bank with an EIDAS alias (with value equal to the
     * authNumber from the certificate) and a public key taken from the certificate.
     * Then onboards it with the provided certificate.
     * A successful onboarding includes verifying the member and the alias and adding permissions
     * based on the certificate.
     * The call is idempotent, so if a member under this realm and with the same verified alias
     * already exists, it returns an ID of the existing member, an ID of the registered eidas key and
     * an ID of the verification for this certificate. If you wish to submit another certificate
     * for an existing member, please use VerifyEidas call instead.
     * Note, that the call is asynchronous and the newly created member might not be onboarded at the
     * time the call returns. You can check the verification status using GetEidasVerificationStatus
     * call with the verification_id returned by this call.
     * @param \Io\Token\Proto\Gateway\RegisterWithEidasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RegisterWithEidas(\Io\Token\Proto\Gateway\RegisterWithEidasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/RegisterWithEidas',
        $argument,
        ['\Io\Token\Proto\Gateway\RegisterWithEidasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Apply member updates. Used when adding/removing keys, aliases to/from member.
     * These updates require a signature.
     * See how Java SDK's Client.updateMember uses it:
     *   https://developer.token.io/sdk/javadoc/io/token/rpc/Client.html#updateMember-io.token.proto.common.member.MemberProtos.Member-java.util.List-
     * See how JS SDK's AuthHttpClient._memberUpdate uses it:
     *   https://developer.token.io/sdk/esdoc/class/src/http/AuthHttpClient.js~AuthHttpClient.html#instance-method-_memberUpdate
     * @param \Io\Token\Proto\Gateway\UpdateMemberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateMember(\Io\Token\Proto\Gateway\UpdateMemberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/UpdateMember',
        $argument,
        ['\Io\Token\Proto\Gateway\UpdateMemberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get information about a member
     * @param \Io\Token\Proto\Gateway\GetMemberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetMember(\Io\Token\Proto\Gateway\GetMemberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetMember',
        $argument,
        ['\Io\Token\Proto\Gateway\GetMemberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * set profile information (display name)
     * Ignores picture fields; use SetProfilePicture for those.
     * https://developer.token.io/sdk/#profile
     * @param \Io\Token\Proto\Gateway\SetProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetProfile(\Io\Token\Proto\Gateway\SetProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SetProfile',
        $argument,
        ['\Io\Token\Proto\Gateway\SetProfileResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get a member's profile (display information)
     * https://developer.token.io/sdk/#profile
     * @param \Io\Token\Proto\Gateway\GetProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetProfile(\Io\Token\Proto\Gateway\GetProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetProfile',
        $argument,
        ['\Io\Token\Proto\Gateway\GetProfileResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * upload an image to use as auth'd member's profile picture
     * Automatically creates smaller sizes; this works best with square images.
     * https://developer.token.io/sdk/#profile
     * @param \Io\Token\Proto\Gateway\SetProfilePictureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetProfilePicture(\Io\Token\Proto\Gateway\SetProfilePictureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SetProfilePicture',
        $argument,
        ['\Io\Token\Proto\Gateway\SetProfilePictureResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get member's profile picture (can also use GetBlob with a blob ID from profile)
     * https://developer.token.io/sdk/#profile
     * @param \Io\Token\Proto\Gateway\GetProfilePictureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetProfilePicture(\Io\Token\Proto\Gateway\GetProfilePictureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetProfilePicture',
        $argument,
        ['\Io\Token\Proto\Gateway\GetProfilePictureResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Set a member's contact (e.g. email) for receipt delivery
     * @param \Io\Token\Proto\Gateway\SetReceiptContactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetReceiptContact(\Io\Token\Proto\Gateway\SetReceiptContactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SetReceiptContact',
        $argument,
        ['\Io\Token\Proto\Gateway\SetReceiptContactResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a member's email address for receipts
     * @param \Io\Token\Proto\Gateway\GetReceiptContactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetReceiptContact(\Io\Token\Proto\Gateway\GetReceiptContactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetReceiptContact',
        $argument,
        ['\Io\Token\Proto\Gateway\GetReceiptContactResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get ID of member that owns an alias, if any.
     * https://developer.token.io/sdk/#aliases
     * @param \Io\Token\Proto\Gateway\ResolveAliasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ResolveAlias(\Io\Token\Proto\Gateway\ResolveAliasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/ResolveAlias',
        $argument,
        ['\Io\Token\Proto\Gateway\ResolveAliasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the auth'd member's aliases.
     * https://developer.token.io/sdk/#aliases
     * @param \Io\Token\Proto\Gateway\GetAliasesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAliases(\Io\Token\Proto\Gateway\GetAliasesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetAliases',
        $argument,
        ['\Io\Token\Proto\Gateway\GetAliasesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use a verification code
     * @param \Io\Token\Proto\Gateway\CompleteVerificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CompleteVerification(\Io\Token\Proto\Gateway\CompleteVerificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CompleteVerification',
        $argument,
        ['\Io\Token\Proto\Gateway\CompleteVerificationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retries verification. For example, if verifying an email alias,
     * re-sends verification-code email to the email address.
     * @param \Io\Token\Proto\Gateway\RetryVerificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RetryVerification(\Io\Token\Proto\Gateway\RetryVerificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/RetryVerification',
        $argument,
        ['\Io\Token\Proto\Gateway\RetryVerificationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get auth'd members paired devices (as created by provisionDevice)
     * @param \Io\Token\Proto\Gateway\GetPairedDevicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetPairedDevices(\Io\Token\Proto\Gateway\GetPairedDevicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetPairedDevices',
        $argument,
        ['\Io\Token\Proto\Gateway\GetPairedDevicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\DeleteMemberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteMember(\Io\Token\Proto\Gateway\DeleteMemberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/DeleteMember',
        $argument,
        ['\Io\Token\Proto\Gateway\DeleteMemberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\NormalizeAliasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function NormalizeAlias(\Io\Token\Proto\Gateway\NormalizeAliasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/NormalizeAlias',
        $argument,
        ['\Io\Token\Proto\Gateway\NormalizeAliasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\SetAppCallbackUrlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetAppCallbackUrl(\Io\Token\Proto\Gateway\SetAppCallbackUrlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SetAppCallbackUrl',
        $argument,
        ['\Io\Token\Proto\Gateway\SetAppCallbackUrlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Member account recovery
     *
     *
     * Begin member recovery. If the member has a "normal consumer" recovery rule,
     * this sends a recovery message to their email address.
     * https://developer.token.io/sdk/#recovery
     * @param \Io\Token\Proto\Gateway\BeginRecoveryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BeginRecovery(\Io\Token\Proto\Gateway\BeginRecoveryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/BeginRecovery',
        $argument,
        ['\Io\Token\Proto\Gateway\BeginRecoveryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Complete member recovery.
     * https://developer.token.io/sdk/#recovery
     * @param \Io\Token\Proto\Gateway\CompleteRecoveryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CompleteRecovery(\Io\Token\Proto\Gateway\CompleteRecoveryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CompleteRecovery',
        $argument,
        ['\Io\Token\Proto\Gateway\CompleteRecoveryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Verify an alias
     * @param \Io\Token\Proto\Gateway\VerifyAliasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function VerifyAlias(\Io\Token\Proto\Gateway\VerifyAliasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/VerifyAlias',
        $argument,
        ['\Io\Token\Proto\Gateway\VerifyAliasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Verify an eidas
     * @param \Io\Token\Proto\Gateway\VerifyEidasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function VerifyEidas(\Io\Token\Proto\Gateway\VerifyEidasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/VerifyEidas',
        $argument,
        ['\Io\Token\Proto\Gateway\VerifyEidasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetEidasVerificationStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetEidasVerificationStatus(\Io\Token\Proto\Gateway\GetEidasVerificationStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetEidasVerificationStatus',
        $argument,
        ['\Io\Token\Proto\Gateway\GetEidasVerificationStatusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetEidasCertificateStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function getEidasCertificateStatus(\Io\Token\Proto\Gateway\GetEidasCertificateStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/getEidasCertificateStatus',
        $argument,
        ['\Io\Token\Proto\Gateway\GetEidasCertificateStatusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Recover an eidas-verified member
     * @param \Io\Token\Proto\Gateway\RecoverEidasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RecoverEidasMember(\Io\Token\Proto\Gateway\RecoverEidasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/RecoverEidasMember',
        $argument,
        ['\Io\Token\Proto\Gateway\RecoverEidasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get member ID of "normal consumer" recovery agent.
     * https://developer.token.io/sdk/#recovery
     * @param \Io\Token\Proto\Gateway\GetDefaultAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetDefaultAgent(\Io\Token\Proto\Gateway\GetDefaultAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetDefaultAgent',
        $argument,
        ['\Io\Token\Proto\Gateway\GetDefaultAgentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Member addresses and preferences
     *
     *
     * Add a shipping address
     * https://developer.token.io/sdk/#address
     * @param \Io\Token\Proto\Gateway\AddAddressRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AddAddress(\Io\Token\Proto\Gateway\AddAddressRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/AddAddress',
        $argument,
        ['\Io\Token\Proto\Gateway\AddAddressResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get one of the auth'd member's shipping addresses
     * https://developer.token.io/sdk/#address
     * @param \Io\Token\Proto\Gateway\GetAddressRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAddress(\Io\Token\Proto\Gateway\GetAddressRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetAddress',
        $argument,
        ['\Io\Token\Proto\Gateway\GetAddressResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get all of the auth'd member's shipping addresses
     * https://developer.token.io/sdk/#address
     * @param \Io\Token\Proto\Gateway\GetAddressesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAddresses(\Io\Token\Proto\Gateway\GetAddressesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetAddresses',
        $argument,
        ['\Io\Token\Proto\Gateway\GetAddressesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Remove one of the auth'd member's shipping addresses
     * https://developer.token.io/sdk/#address
     * @param \Io\Token\Proto\Gateway\DeleteAddressRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteAddress(\Io\Token\Proto\Gateway\DeleteAddressRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/DeleteAddress',
        $argument,
        ['\Io\Token\Proto\Gateway\DeleteAddressResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Add a trusted beneficiary
     * https://developer.token.io/sdk/#trusted-beneficiary
     * @param \Io\Token\Proto\Gateway\AddTrustedBeneficiaryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AddTrustedBeneficiary(\Io\Token\Proto\Gateway\AddTrustedBeneficiaryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/AddTrustedBeneficiary',
        $argument,
        ['\Io\Token\Proto\Gateway\AddTrustedBeneficiaryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Remove a trusted beneficiary
     * https://developer.token.io/sdk/#trusted-beneficiary
     * @param \Io\Token\Proto\Gateway\RemoveTrustedBeneficiaryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RemoveTrustedBeneficiary(\Io\Token\Proto\Gateway\RemoveTrustedBeneficiaryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/RemoveTrustedBeneficiary',
        $argument,
        ['\Io\Token\Proto\Gateway\RemoveTrustedBeneficiaryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get all trusted beneficiaries
     * https://developer.token.io/sdk/#trusted-beneficiary
     * @param \Io\Token\Proto\Gateway\GetTrustedBeneficiariesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTrustedBeneficiaries(\Io\Token\Proto\Gateway\GetTrustedBeneficiariesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTrustedBeneficiaries',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTrustedBeneficiariesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Set Customization
     * https://developer.token.io/sdk/#customization
     * @param \Io\Token\Proto\Gateway\CreateCustomizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateCustomization(\Io\Token\Proto\Gateway\CreateCustomizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateCustomization',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateCustomizationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Devices for notification service
     *
     *
     * subscribe member to notifications
     * https://developer.token.io/sdk/#notifications
     * @param \Io\Token\Proto\Gateway\SubscribeToNotificationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SubscribeToNotifications(\Io\Token\Proto\Gateway\SubscribeToNotificationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SubscribeToNotifications',
        $argument,
        ['\Io\Token\Proto\Gateway\SubscribeToNotificationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get member's notification subscriber[s]
     * https://developer.token.io/sdk/#notifications
     * @param \Io\Token\Proto\Gateway\GetSubscribersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSubscribers(\Io\Token\Proto\Gateway\GetSubscribersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetSubscribers',
        $argument,
        ['\Io\Token\Proto\Gateway\GetSubscribersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get one of a member's notification subscribers
     * https://developer.token.io/sdk/#notifications
     * @param \Io\Token\Proto\Gateway\GetSubscriberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSubscriber(\Io\Token\Proto\Gateway\GetSubscriberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetSubscriber',
        $argument,
        ['\Io\Token\Proto\Gateway\GetSubscriberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * unsubscribe one of a member's subscribers from notifications
     * https://developer.token.io/sdk/#notifications
     * @param \Io\Token\Proto\Gateway\UnsubscribeFromNotificationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UnsubscribeFromNotifications(\Io\Token\Proto\Gateway\UnsubscribeFromNotificationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/UnsubscribeFromNotifications',
        $argument,
        ['\Io\Token\Proto\Gateway\UnsubscribeFromNotificationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * send a notification
     * https://developer.token.io/sdk/#notifications
     * @param \Io\Token\Proto\Gateway\NotifyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Notify(\Io\Token\Proto\Gateway\NotifyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/Notify',
        $argument,
        ['\Io\Token\Proto\Gateway\NotifyResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get notifications
     * https://developer.token.io/sdk/#polling-for-notifications
     * @param \Io\Token\Proto\Gateway\GetNotificationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetNotifications(\Io\Token\Proto\Gateway\GetNotificationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetNotifications',
        $argument,
        ['\Io\Token\Proto\Gateway\GetNotificationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get one particular notification
     * https://developer.token.io/sdk/#polling-for-notifications
     * @param \Io\Token\Proto\Gateway\GetNotificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetNotification(\Io\Token\Proto\Gateway\GetNotificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetNotification',
        $argument,
        ['\Io\Token\Proto\Gateway\GetNotificationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * send transfer-request notification
     * https://developer.token.io/sdk/#request-payment
     * @param \Io\Token\Proto\Gateway\RequestTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RequestTransfer(\Io\Token\Proto\Gateway\RequestTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/RequestTransfer',
        $argument,
        ['\Io\Token\Proto\Gateway\RequestTransferResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * send step-up (approve with higher-privilege key) request notification
     * @param \Io\Token\Proto\Gateway\TriggerStepUpNotificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function TriggerStepUpNotification(\Io\Token\Proto\Gateway\TriggerStepUpNotificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/TriggerStepUpNotification',
        $argument,
        ['\Io\Token\Proto\Gateway\TriggerStepUpNotificationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * send endorse and add key notification (approve with higher-privilege key)
     * @param \Io\Token\Proto\Gateway\TriggerEndorseAndAddKeyNotificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function TriggerEndorseAndAddKeyNotification(\Io\Token\Proto\Gateway\TriggerEndorseAndAddKeyNotificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/TriggerEndorseAndAddKeyNotification',
        $argument,
        ['\Io\Token\Proto\Gateway\TriggerEndorseAndAddKeyNotificationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * send create and endorse token notification
     * @param \Io\Token\Proto\Gateway\TriggerCreateAndEndorseTokenNotificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function TriggerCreateAndEndorseTokenNotification(\Io\Token\Proto\Gateway\TriggerCreateAndEndorseTokenNotificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/TriggerCreateAndEndorseTokenNotification',
        $argument,
        ['\Io\Token\Proto\Gateway\TriggerCreateAndEndorseTokenNotificationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * send invalidate notification
     * @param \Io\Token\Proto\Gateway\InvalidateNotificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function InvalidateNotification(\Io\Token\Proto\Gateway\InvalidateNotificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/InvalidateNotification',
        $argument,
        ['\Io\Token\Proto\Gateway\InvalidateNotificationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * update notification status
     * @param \Io\Token\Proto\Gateway\UpdateNotificationStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateNotificationStatus(\Io\Token\Proto\Gateway\UpdateNotificationStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/UpdateNotificationStatus',
        $argument,
        ['\Io\Token\Proto\Gateway\UpdateNotificationStatusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Bank accounts.
     *
     *
     * associate bank accounts with member
     * https://developer.token.io/sdk/#link-a-bank-account
     * @param \Io\Token\Proto\Gateway\LinkAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function LinkAccounts(\Io\Token\Proto\Gateway\LinkAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/LinkAccounts',
        $argument,
        ['\Io\Token\Proto\Gateway\LinkAccountsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * associate bank accounts with member
     * https://developer.token.io/sdk/#link-a-bank-account
     * @param \Io\Token\Proto\Gateway\LinkAccountsOauthRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function LinkAccountsOauth(\Io\Token\Proto\Gateway\LinkAccountsOauthRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/LinkAccountsOauth',
        $argument,
        ['\Io\Token\Proto\Gateway\LinkAccountsOauthResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * un-associate bank accounts with member
     * https://developer.token.io/sdk/#link-a-bank-account
     * @param \Io\Token\Proto\Gateway\UnlinkAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UnlinkAccounts(\Io\Token\Proto\Gateway\UnlinkAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/UnlinkAccounts',
        $argument,
        ['\Io\Token\Proto\Gateway\UnlinkAccountsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get info about one linked account
     * https://developer.token.io/sdk/#get-accounts
     * @param \Io\Token\Proto\Gateway\GetAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAccount(\Io\Token\Proto\Gateway\GetAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetAccount',
        $argument,
        ['\Io\Token\Proto\Gateway\GetAccountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get info about linked accounts
     * https://developer.token.io/sdk/#get-accounts
     * @param \Io\Token\Proto\Gateway\GetAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAccounts(\Io\Token\Proto\Gateway\GetAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetAccounts',
        $argument,
        ['\Io\Token\Proto\Gateway\GetAccountsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get current and available balance for a linked account
     * https://developer.token.io/sdk/#get-account-balance
     * @param \Io\Token\Proto\Gateway\GetBalanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBalance(\Io\Token\Proto\Gateway\GetBalanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBalance',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBalanceResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetBalancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBalances(\Io\Token\Proto\Gateway\GetBalancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBalances',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBalancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get information about a particular transaction
     * https://developer.token.io/sdk/#get-transactions
     * @param \Io\Token\Proto\Gateway\GetTransactionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTransaction(\Io\Token\Proto\Gateway\GetTransactionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTransaction',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get information about several transactions
     * https://developer.token.io/sdk/#get-transactions
     * @param \Io\Token\Proto\Gateway\GetTransactionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTransactions(\Io\Token\Proto\Gateway\GetTransactionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTransactions',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTransactionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get information about a particular standing order
     * @param \Io\Token\Proto\Gateway\GetStandingOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetStandingOrder(\Io\Token\Proto\Gateway\GetStandingOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetStandingOrder',
        $argument,
        ['\Io\Token\Proto\Gateway\GetStandingOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * get information about several standing orders
     * @param \Io\Token\Proto\Gateway\GetStandingOrdersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetStandingOrders(\Io\Token\Proto\Gateway\GetStandingOrdersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetStandingOrders',
        $argument,
        ['\Io\Token\Proto\Gateway\GetStandingOrdersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\ApplyScaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ApplySca(\Io\Token\Proto\Gateway\ApplyScaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/ApplySca',
        $argument,
        ['\Io\Token\Proto\Gateway\ApplyScaResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get information about the auth'd member's default account.
     * https://developer.token.io/sdk/#default-bank-account
     * @param \Io\Token\Proto\Gateway\GetDefaultAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetDefaultAccount(\Io\Token\Proto\Gateway\GetDefaultAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetDefaultAccount',
        $argument,
        ['\Io\Token\Proto\Gateway\GetDefaultAccountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Set one auth'd member's accounts as its default account.
     * https://developer.token.io/sdk/#default-bank-account
     * @param \Io\Token\Proto\Gateway\SetDefaultAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetDefaultAccount(\Io\Token\Proto\Gateway\SetDefaultAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SetDefaultAccount',
        $argument,
        ['\Io\Token\Proto\Gateway\SetDefaultAccountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the resolved transfer destinations of the given account.
     * @param \Io\Token\Proto\Gateway\ResolveTransferDestinationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ResolveTransferDestinations(\Io\Token\Proto\Gateway\ResolveTransferDestinationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/ResolveTransferDestinations',
        $argument,
        ['\Io\Token\Proto\Gateway\ResolveTransferDestinationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Confirm that the given account has sufficient funds to cover the charge.
     * @param \Io\Token\Proto\Gateway\ConfirmFundsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ConfirmFunds(\Io\Token\Proto\Gateway\ConfirmFundsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/ConfirmFunds',
        $argument,
        ['\Io\Token\Proto\Gateway\ConfirmFundsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Testing.
     *
     *
     * Create a test account at "iron" test bank.
     * https://developer.token.io/sdk/#link-a-bank-account
     * @param \Io\Token\Proto\Gateway\CreateTestBankAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateTestBankAccount(\Io\Token\Proto\Gateway\CreateTestBankAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateTestBankAccount',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateTestBankAccountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get notification from "iron" test bank. Useful for Token when testing its test bank.
     * Normal way to get a notification is GetNotification.
     * @param \Io\Token\Proto\Gateway\GetTestBankNotificationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTestBankNotification(\Io\Token\Proto\Gateway\GetTestBankNotificationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTestBankNotification',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTestBankNotificationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get notifications from "iron" test bank. Useful for Token when testing its test bank.
     * Normal way to get notifications is GetNotifications.
     * @param \Io\Token\Proto\Gateway\GetTestBankNotificationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTestBankNotifications(\Io\Token\Proto\Gateway\GetTestBankNotificationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTestBankNotifications',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTestBankNotificationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Blobs.
     *
     *
     * Create a blob.
     * https://developer.token.io/sdk/#transfer-token-options
     * @param \Io\Token\Proto\Gateway\CreateBlobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateBlob(\Io\Token\Proto\Gateway\CreateBlobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateBlob',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateBlobResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetch a blob. Works if the authenticated member is the blob's
     * owner or if the blob is public-access.
     * https://developer.token.io/sdk/#transfer-token-options
     * @param \Io\Token\Proto\Gateway\GetBlobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBlob(\Io\Token\Proto\Gateway\GetBlobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBlob',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBlobResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetch a blob using a Token's authority. Works if Blob is attached to token
     * and authenticated member is the Token's "from" or "to".
     * https://developer.token.io/sdk/#transfer-token-options
     * @param \Io\Token\Proto\Gateway\GetTokenBlobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTokenBlob(\Io\Token\Proto\Gateway\GetTokenBlobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTokenBlob',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTokenBlobResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Tokens Requests.
     *
     *
     * Store a Token Request
     * @param \Io\Token\Proto\Gateway\StoreTokenRequestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function StoreTokenRequest(\Io\Token\Proto\Gateway\StoreTokenRequestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/StoreTokenRequest',
        $argument,
        ['\Io\Token\Proto\Gateway\StoreTokenRequestResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve a Token Request
     * @param \Io\Token\Proto\Gateway\RetrieveTokenRequestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RetrieveTokenRequest(\Io\Token\Proto\Gateway\RetrieveTokenRequestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/RetrieveTokenRequest',
        $argument,
        ['\Io\Token\Proto\Gateway\RetrieveTokenRequestResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\UpdateTokenRequestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateTokenRequest(\Io\Token\Proto\Gateway\UpdateTokenRequestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/UpdateTokenRequest',
        $argument,
        ['\Io\Token\Proto\Gateway\UpdateTokenRequestResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\SetTokenRequestTransferDestinationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetTokenRequestTransferDestinations(\Io\Token\Proto\Gateway\SetTokenRequestTransferDestinationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SetTokenRequestTransferDestinations',
        $argument,
        ['\Io\Token\Proto\Gateway\SetTokenRequestTransferDestinationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Tokens.
     *
     *
     * Prepare a token (resolve token payload and determine policy)
     * @param \Io\Token\Proto\Gateway\PrepareTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PrepareToken(\Io\Token\Proto\Gateway\PrepareTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/PrepareToken',
        $argument,
        ['\Io\Token\Proto\Gateway\PrepareTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a Token.
     * @param \Io\Token\Proto\Gateway\CreateTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateToken(\Io\Token\Proto\Gateway\CreateTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateToken',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a Transfer Token.
     * https://developer.token.io/sdk/#create-transfer-token
     * @param \Io\Token\Proto\Gateway\CreateTransferTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateTransferToken(\Io\Token\Proto\Gateway\CreateTransferTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateTransferToken',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateTransferTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create an Access Token.
     * https://developer.token.io/sdk/#create-access-token
     * @param \Io\Token\Proto\Gateway\CreateAccessTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateAccessToken(\Io\Token\Proto\Gateway\CreateAccessTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateAccessToken',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateAccessTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get information about one token.
     * https://developer.token.io/sdk/#redeem-transfer-token
     * @param \Io\Token\Proto\Gateway\GetTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetToken(\Io\Token\Proto\Gateway\GetTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetToken',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get existing Access Token where the calling member is the
     * remitter and provided member is the beneficiary.
     * @param \Io\Token\Proto\Gateway\GetActiveAccessTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetActiveAccessToken(\Io\Token\Proto\Gateway\GetActiveAccessTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetActiveAccessToken',
        $argument,
        ['\Io\Token\Proto\Gateway\GetActiveAccessTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets list of tokens the member has given/received.
     * Used by getTransferTokens, getAccessTokens.
     * https://developer.token.io/sdk/#get-tokens
     * https://developer.token.io/sdk/#replace-access-token
     * @param \Io\Token\Proto\Gateway\GetTokensRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTokens(\Io\Token\Proto\Gateway\GetTokensRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTokens',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTokensResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Endorse a token
     * https://developer.token.io/sdk/#endorse-transfer-token
     * https://developer.token.io/sdk/#endorse-access-token
     * @param \Io\Token\Proto\Gateway\EndorseTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function EndorseToken(\Io\Token\Proto\Gateway\EndorseTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/EndorseToken',
        $argument,
        ['\Io\Token\Proto\Gateway\EndorseTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancel a token
     * https://developer.token.io/sdk/#cancel-transfer-token
     * https://developer.token.io/sdk/#cancel-access-token
     * @param \Io\Token\Proto\Gateway\CancelTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CancelToken(\Io\Token\Proto\Gateway\CancelTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CancelToken',
        $argument,
        ['\Io\Token\Proto\Gateway\CancelTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Replace an access token
     * https://developer.token.io/sdk/#replace-access-token
     *
     * See how replaceAndEndorseToken uses it:
     *   https://developer.token.io/sdk/esdoc/class/src/http/AuthHttpClient.js~AuthHttpClient.html#instance-method-replaceAndEndorseToken
     * @param \Io\Token\Proto\Gateway\ReplaceTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ReplaceToken(\Io\Token\Proto\Gateway\ReplaceTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/ReplaceToken',
        $argument,
        ['\Io\Token\Proto\Gateway\ReplaceTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Request a Token signature on a token request state payload (tokenId | state)
     * @param \Io\Token\Proto\Gateway\SignTokenRequestStateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SignTokenRequestState(\Io\Token\Proto\Gateway\SignTokenRequestStateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SignTokenRequestState',
        $argument,
        ['\Io\Token\Proto\Gateway\SignTokenRequestStateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the token request result from the token request id
     * @param \Io\Token\Proto\Gateway\GetTokenRequestResultRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTokenRequestResult(\Io\Token\Proto\Gateway\GetTokenRequestResultRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTokenRequestResult',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTokenRequestResultResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a payload to sign
     * @param \Io\Token\Proto\Gateway\GetAuthRequestPayloadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAuthRequestPayload(\Io\Token\Proto\Gateway\GetAuthRequestPayloadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetAuthRequestPayload',
        $argument,
        ['\Io\Token\Proto\Gateway\GetAuthRequestPayloadResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Stores a linking request
     * @param \Io\Token\Proto\Gateway\StoreLinkingRequestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function StoreLinkingRequest(\Io\Token\Proto\Gateway\StoreLinkingRequestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/StoreLinkingRequest',
        $argument,
        ['\Io\Token\Proto\Gateway\StoreLinkingRequestResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a linking request
     * @param \Io\Token\Proto\Gateway\GetLinkingRequestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetLinkingRequest(\Io\Token\Proto\Gateway\GetLinkingRequestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetLinkingRequest',
        $argument,
        ['\Io\Token\Proto\Gateway\GetLinkingRequestResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Token Transfers.
     *
     *
     * Redeem a transfer token, creating a transfer.
     * https://developer.token.io/sdk/#redeem-transfer-token
     *
     * See how redeemToken calls it:
     *   https://developer.token.io/sdk/esdoc/class/src/http/AuthHttpClient.js~AuthHttpClient.html#instance-method-redeemToken
     * @param \Io\Token\Proto\Gateway\CreateTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateTransfer(\Io\Token\Proto\Gateway\CreateTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateTransfer',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateTransferResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Redeem a standing order token, creating a standing order submission.
     * @param \Io\Token\Proto\Gateway\CreateStandingOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateStandingOrder(\Io\Token\Proto\Gateway\CreateStandingOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateStandingOrder',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateStandingOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Redeem a bulk transfer token, creating a bulk transfer submission.
     * @param \Io\Token\Proto\Gateway\CreateBulkTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateBulkTransfer(\Io\Token\Proto\Gateway\CreateBulkTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateBulkTransfer',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateBulkTransferResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get information about one transfer.
     * https://developer.token.io/sdk/#get-transfers
     * @param \Io\Token\Proto\Gateway\GetTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTransfer(\Io\Token\Proto\Gateway\GetTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTransfer',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTransferResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get information about one standing order submission
     * @param \Io\Token\Proto\Gateway\GetStandingOrderSubmissionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetStandingOrderSubmission(\Io\Token\Proto\Gateway\GetStandingOrderSubmissionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetStandingOrderSubmission',
        $argument,
        ['\Io\Token\Proto\Gateway\GetStandingOrderSubmissionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get information about one bulk transfer
     * @param \Io\Token\Proto\Gateway\GetBulkTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBulkTransfer(\Io\Token\Proto\Gateway\GetBulkTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBulkTransfer',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBulkTransferResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a list of the auth'd member's submissions.
     * https://developer.token.io/sdk/#get-submissions
     * @param \Io\Token\Proto\Gateway\GetTransfersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTransfers(\Io\Token\Proto\Gateway\GetTransfersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTransfers',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTransfersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a list of the auth'd member's recurring submissions.
     * @param \Io\Token\Proto\Gateway\GetStandingOrderSubmissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetStandingOrderSubmissions(\Io\Token\Proto\Gateway\GetStandingOrderSubmissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetStandingOrderSubmissions',
        $argument,
        ['\Io\Token\Proto\Gateway\GetStandingOrderSubmissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Bank Information Endpoints.
     *
     *
     * Get a list of "link-able" bank countries.
     * @param \Io\Token\Proto\Gateway\GetBanksCountriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBanksCountries(\Io\Token\Proto\Gateway\GetBanksCountriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBanksCountries',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBanksCountriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a list of "link-able" banks.
     * https://developer.token.io/sdk/#link-a-bank-account
     * @param \Io\Token\Proto\Gateway\GetBanksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBanks(\Io\Token\Proto\Gateway\GetBanksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBanks',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBanksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get information useful for linking one bank.
     * https://developer.token.io/sdk/#link-a-bank-account
     * @param \Io\Token\Proto\Gateway\GetBankInfoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBankInfo(\Io\Token\Proto\Gateway\GetBankInfoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBankInfo',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBankInfoResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetBankAuthUrlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBankAuthUrl(\Io\Token\Proto\Gateway\GetBankAuthUrlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBankAuthUrl',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBankAuthUrlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetDirectBankAuthUrlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetDirectBankAuthUrl(\Io\Token\Proto\Gateway\GetDirectBankAuthUrlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetDirectBankAuthUrl',
        $argument,
        ['\Io\Token\Proto\Gateway\GetDirectBankAuthUrlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * TSP only endpoints
     *
     * @param \Io\Token\Proto\Gateway\OnBankAuthCallbackRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function OnBankAuthCallback(\Io\Token\Proto\Gateway\OnBankAuthCallbackRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/OnBankAuthCallback',
        $argument,
        ['\Io\Token\Proto\Gateway\OnBankAuthCallbackResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetExternalMetadataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetExternalMetadata(\Io\Token\Proto\Gateway\GetExternalMetadataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetExternalMetadata',
        $argument,
        ['\Io\Token\Proto\Gateway\GetExternalMetadataResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\StoreBankConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function StoreBankConfig(\Io\Token\Proto\Gateway\StoreBankConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/StoreBankConfig',
        $argument,
        ['\Io\Token\Proto\Gateway\StoreBankConfigResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetBankConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBankConfig(\Io\Token\Proto\Gateway\GetBankConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBankConfig',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBankConfigResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetBankConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBankConfigs(\Io\Token\Proto\Gateway\GetBankConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBankConfigs',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBankConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\DeleteBankConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteBankConfig(\Io\Token\Proto\Gateway\DeleteBankConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/DeleteBankConfig',
        $argument,
        ['\Io\Token\Proto\Gateway\DeleteBankConfigResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Bank member only requests.
     *
     * Get member information about a member who links at least an account from this bank
     * @param \Io\Token\Proto\Gateway\GetMemberInfoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetMemberInfo(\Io\Token\Proto\Gateway\GetMemberInfoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetMemberInfo',
        $argument,
        ['\Io\Token\Proto\Gateway\GetMemberInfoResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetConsentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConsent(\Io\Token\Proto\Gateway\GetConsentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetConsent',
        $argument,
        ['\Io\Token\Proto\Gateway\GetConsentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetConsentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConsents(\Io\Token\Proto\Gateway\GetConsentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetConsents',
        $argument,
        ['\Io\Token\Proto\Gateway\GetConsentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Reports (bank member only requests).
     *
     * Get TPP performance report.
     * @param \Io\Token\Proto\Gateway\GetTppPerformanceReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTppPerformanceReport(\Io\Token\Proto\Gateway\GetTppPerformanceReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTppPerformanceReport',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTppPerformanceReportResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get availability report.
     * @param \Io\Token\Proto\Gateway\GetAvailabilityReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAvailabilityReport(\Io\Token\Proto\Gateway\GetAvailabilityReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetAvailabilityReport',
        $argument,
        ['\Io\Token\Proto\Gateway\GetAvailabilityReportResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetTppAccessReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTppAccessReport(\Io\Token\Proto\Gateway\GetTppAccessReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTppAccessReport',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTppAccessReportResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Reports (portal requests).
     *
     * Get TPP requests report.
     * @param \Io\Token\Proto\Gateway\GetTppRequestsReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTppRequestsReport(\Io\Token\Proto\Gateway\GetTppRequestsReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetTppRequestsReport',
        $argument,
        ['\Io\Token\Proto\Gateway\GetTppRequestsReportResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetBankDowntimeReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBankDowntimeReport(\Io\Token\Proto\Gateway\GetBankDowntimeReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBankDowntimeReport',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBankDowntimeReportResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetBankStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBankStatus(\Io\Token\Proto\Gateway\GetBankStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBankStatus',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBankStatusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetBanksStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetBanksStatus(\Io\Token\Proto\Gateway\GetBanksStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetBanksStatus',
        $argument,
        ['\Io\Token\Proto\Gateway\GetBanksStatusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * RESTful Bank API
     *
     * @param \Io\Token\Proto\Gateway\CreateBankUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateBankUser(\Io\Token\Proto\Gateway\CreateBankUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateBankUser',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateBankUserResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\DeleteBankUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteBankUser(\Io\Token\Proto\Gateway\DeleteBankUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/DeleteBankUser',
        $argument,
        ['\Io\Token\Proto\Gateway\DeleteBankUserResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\RetrieveConsentRequestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RetrieveConsentRequest(\Io\Token\Proto\Gateway\RetrieveConsentRequestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/RetrieveConsentRequest',
        $argument,
        ['\Io\Token\Proto\Gateway\RetrieveConsentRequestResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\CreateConsentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateConsent(\Io\Token\Proto\Gateway\CreateConsentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CreateConsent',
        $argument,
        ['\Io\Token\Proto\Gateway\CreateConsentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\CancelConsentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CancelConsent(\Io\Token\Proto\Gateway\CancelConsentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/CancelConsent',
        $argument,
        ['\Io\Token\Proto\Gateway\CancelConsentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetActiveAccessConsentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetActiveAccessConsents(\Io\Token\Proto\Gateway\GetActiveAccessConsentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetActiveAccessConsents',
        $argument,
        ['\Io\Token\Proto\Gateway\GetActiveAccessConsentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Partner endpoints
     *
     * @param \Io\Token\Proto\Gateway\EnableMemberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function EnableMember(\Io\Token\Proto\Gateway\EnableMemberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/EnableMember',
        $argument,
        ['\Io\Token\Proto\Gateway\EnableMemberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\DisableMemberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DisableMember(\Io\Token\Proto\Gateway\DisableMemberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/DisableMember',
        $argument,
        ['\Io\Token\Proto\Gateway\DisableMemberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////
     * Webhook endpoints
     *
     * @param \Io\Token\Proto\Gateway\SetWebhookConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetWebhookConfig(\Io\Token\Proto\Gateway\SetWebhookConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/SetWebhookConfig',
        $argument,
        ['\Io\Token\Proto\Gateway\SetWebhookConfigResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\GetWebhookConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetWebhookConfig(\Io\Token\Proto\Gateway\GetWebhookConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/GetWebhookConfig',
        $argument,
        ['\Io\Token\Proto\Gateway\GetWebhookConfigResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Io\Token\Proto\Gateway\DeleteWebhookConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteWebhookConfig(\Io\Token\Proto\Gateway\DeleteWebhookConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/io.token.proto.gateway.GatewayService/DeleteWebhookConfig',
        $argument,
        ['\Io\Token\Proto\Gateway\DeleteWebhookConfigResponse', 'decode'],
        $metadata, $options);
    }

}
