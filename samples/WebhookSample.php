<?php

namespace Io\Token\Samples;

use Io\Token\Proto\Common\Webhook\Webhook\Config;
use Io\Token\Proto\Common\Webhook\EventType;
use Tokenio\Member;
use Tokenio\Util\Util;

final class WebhookSample
{
    /**
     * Sets a webhook config.
     *
     * @param Member $tpp the tpp member
     * @return bool that completes when request handled
     */
    public static function SetWebhookConfig($tpp)
    {
        $config = new Config();
        $types = array();
        $types[] = EventType::TRANSFER_STATUS_CHANGED;
        $config->setUrl("https://example.token.io/webhook")
            ->setType($types);

        return $tpp->SetWebhookConfig($config);
    }

    /**
     * Gets the webhook config.
     *
     * @param Member $tpp the tpp member
     * @return Config the webhook config
     */
    public static function GetWebhookConfig($tpp)
    {
        return $tpp->GetWebhookConfig();
    }

    /**
     * Deletes the webhook config.
     *
     * @param Member $tpp the tpp member
     * @return bool that completes when request handled
     */
    public static function DeleteWebhookConfig($tpp)
    {
        return $tpp->DeleteWebhookConfig();
    }
}
