<?php


namespace Tokenio\Sample\Tpp;


use Io\Token\Proto\Common\Token\Token;
use Tokenio\PagedList;
use Tokenio\Tpp\Member;

class GetTokensSample
{

    /**
     * Gets a token by ID
     *
     * @param $member Member  member represented by the token
     * @param $tokenId string
     * @return Token
     * @throws \Exception
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
     * @param $member Member
     * @return PagedList
     * @throws \Exception
     */
    public static function getTransferTokens($member)
    {
        return $member->getTransferTokens("", 10);
    }

    /**
     * Gets a list of access tokens associated with the member.
     * @param $member Member
     * @return PagedList
     * @throws \Exception
     */
    public static function getAccessTokens($member)
    {
        return $member->getAccessTokens("", 10);
    }
}