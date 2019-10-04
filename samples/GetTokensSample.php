<?php


namespace Io\Token\Samples;


class GetTokensSample
{

    /**
     * Gets a token by ID
     *
     * @param $member \Tokenio\Member  member represented by the token
     * @param $tokenId string
     */
    public static function getToken($member, $tokenId)
    {
        $token = $member->getToken($tokenId);

        $payload = $token->getPayload();

        $signatures = $token->getPayloadSignatures();

        return $token;
    }

    /**
     * Gets a list of transfer tokens associated with a member
     * @param $member \Tokenio\Member
     */
    public static function getTransferTokens($member)
    {
        return $member->getTransferTokens("", 10);
    }

    /**
     * Gets a list of access tokens associated with the member.
     * @param $member \Tokenio\Member
     * @return mixed
     */
    public static function getAccessTokens($member)
    {
        return $member->getAccessTokens("", 10);
    }
}