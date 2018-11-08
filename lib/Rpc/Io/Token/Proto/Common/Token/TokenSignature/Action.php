<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace Io\Token\Proto\Common\Token\TokenSignature;

/**
 * List of valid actions that one can perform on the Token. We use lowercase string value
 * of the action when computing a signature.
 *
 * Protobuf type <code>io.token.proto.common.token.TokenSignature.Action</code>
 */
class Action
{
    /**
     * Generated from protobuf enum <code>INVALID = 0;</code>
     */
    const INVALID = 0;
    /**
     * Endorses token. Both payer and payer bank co-endorse the token.
     *
     * Generated from protobuf enum <code>ENDORSED = 1;</code>
     */
    const ENDORSED = 1;
    /**
     * Revoked by the payer or declined by the redeemer.
     *
     * Generated from protobuf enum <code>CANCELLED = 2;</code>
     */
    const CANCELLED = 2;
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Action::class, \Io\Token\Proto\Common\Token\TokenSignature_Action::class);

