<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: account.proto

namespace GPBMetadata;

class Account
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Banklink::initOnce();
        \GPBMetadata\Extensions\Field::initOnce();
        \GPBMetadata\Extensions\Message::initOnce();
        \GPBMetadata\Providerspecific::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0a8e140a0d6163636f756e742e70726f746f121d696f2e746f6b656e2e70" .
            "726f746f2e636f6d6d6f6e2e6163636f756e741a16657874656e73696f6e" .
            "732f6669656c642e70726f746f1a18657874656e73696f6e732f6d657373" .
            "6167652e70726f746f1a1670726f766964657273706563696669632e7072" .
            "6f746f22a5010a1a506c61696e7465787442616e6b417574686f72697a61" .
            "74696f6e12110a096d656d6265725f6964180120012809121a0a0c616363" .
            "6f756e745f6e616d65180220012809420480b5180112410a076163636f75" .
            "6e7418032001280b322a2e696f2e746f6b656e2e70726f746f2e636f6d6d" .
            "6f6e2e6163636f756e742e42616e6b4163636f756e74420480b518011215" .
            "0a0d65787069726174696f6e5f6d7318042001280322aa010a0f4163636f" .
            "756e74466561747572657312180a10737570706f7274735f7061796d656e" .
            "74180120012808121c0a14737570706f7274735f696e666f726d6174696f" .
            "6e180220012808121e0a1672657175697265735f65787465726e616c5f61" .
            "757468180320012808121d0a15737570706f7274735f73656e645f706179" .
            "6d656e7418042001280812200a18737570706f7274735f72656365697665" .
            "5f7061796d656e7418052001280822aa030a0e4163636f756e7444657461" .
            "696c7312120a0a6964656e74696669657218012001280912470a04747970" .
            "6518022001280e32392e696f2e746f6b656e2e70726f746f2e636f6d6d6f" .
            "6e2e6163636f756e742e4163636f756e7444657461696c732e4163636f75" .
            "6e7454797065120e0a0673746174757318032001280912530a086d657461" .
            "6461746118042003280b323b2e696f2e746f6b656e2e70726f746f2e636f" .
            "6d6d6f6e2e6163636f756e742e4163636f756e7444657461696c732e4d65" .
            "746164617461456e747279420480b5180112590a1170726f76696465725f" .
            "737065636966696318052001280b323e2e696f2e746f6b656e2e70726f74" .
            "6f2e636f6d6d6f6e2e70726f766964657273706563696669632e50726f76" .
            "696465724163636f756e7444657461696c731a2f0a0d4d65746164617461" .
            "456e747279120b0a036b6579180120012809120d0a0576616c7565180220" .
            "0128093a023801224a0a0b4163636f756e7454797065120b0a07494e5641" .
            "4c4944100012090a054f544845521001120c0a08434845434b494e471002" .
            "120b0a07534156494e4753100312080a044c4f414e1004229b020a074163" .
            "636f756e74120a0a02696418012001280912120a046e616d651802200128" .
            "09420480b51801120f0a0762616e6b5f696418032001280912110a096973" .
            "5f6c6f636b656418052001280812480a106163636f756e745f6665617475" .
            "72657318062001280b322e2e696f2e746f6b656e2e70726f746f2e636f6d" .
            "6d6f6e2e6163636f756e742e4163636f756e744665617475726573121c0a" .
            "146c6173745f63616368655f7570646174655f6d73180720012803121c0a" .
            "146e6578745f63616368655f7570646174655f6d7318082001280312460a" .
            "0f6163636f756e745f64657461696c7318092001280b322d2e696f2e746f" .
            "6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e4163636f75" .
            "6e7444657461696c7322b50a0a0b42616e6b4163636f756e7412410a0574" .
            "6f6b656e18012001280b32302e696f2e746f6b656e2e70726f746f2e636f" .
            "6d6d6f6e2e6163636f756e742e42616e6b4163636f756e742e546f6b656e" .
            "480012600a13746f6b656e5f617574686f72697a6174696f6e1802200128" .
            "0b323d2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f" .
            "756e742e42616e6b4163636f756e742e546f6b656e417574686f72697a61" .
            "74696f6e42021801480012410a05737769667418032001280b32302e696f" .
            "2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e4261" .
            "6e6b4163636f756e742e53776966744800123f0a04736570611804200128" .
            "0b322f2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f" .
            "756e742e42616e6b4163636f756e742e536570614800123d0a0361636818" .
            "052001280b322e2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e" .
            "6163636f756e742e42616e6b4163636f756e742e4163684800123f0a0462" .
            "616e6b18062001280b322f2e696f2e746f6b656e2e70726f746f2e636f6d" .
            "6d6f6e2e6163636f756e742e42616e6b4163636f756e742e42616e6b4800" .
            "12540a0f6661737465725f7061796d656e747318092001280b32392e696f" .
            "2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e4261" .
            "6e6b4163636f756e742e4661737465725061796d656e7473480012430a06" .
            "637573746f6d180a2001280b32312e696f2e746f6b656e2e70726f746f2e" .
            "636f6d6d6f6e2e6163636f756e742e42616e6b4163636f756e742e437573" .
            "746f6d480012410a056775657374180b2001280b32302e696f2e746f6b65" .
            "6e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b416363" .
            "6f756e742e4775657374480012500a086d6574616461746118072003280b" .
            "32382e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f75" .
            "6e742e42616e6b4163636f756e742e4d65746164617461456e7472794204" .
            "80b5180112480a106163636f756e745f666561747572657318082001280b" .
            "322e2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f75" .
            "6e742e4163636f756e7446656174757265731a2e0a05546f6b656e12110a" .
            "096d656d6265725f696418012001280912120a0a6163636f756e745f6964" .
            "1802200128091a5b0a12546f6b656e417574686f72697a6174696f6e1241" .
            "0a0d617574686f72697a6174696f6e18012001280b322a2e696f2e746f6b" .
            "656e2e70726f746f2e62616e6b6c696e6b2e42616e6b417574686f72697a" .
            "6174696f6e3a0218011a170a0442616e6b120f0a0762616e6b5f69641801" .
            "200128091a2b0a055377696674120b0a03626963180120012809120f0a07" .
            "6163636f756e741802200128093a0480b518011a270a0453657061120c0a" .
            "046962616e180120012809120b0a036269631802200128093a0480b51801" .
            "1a2d0a03416368120f0a07726f7574696e67180120012809120f0a076163" .
            "636f756e741802200128093a0480b518011a410a0e466173746572506179" .
            "6d656e747312110a09736f72745f636f646518012001280912160a0e6163" .
            "636f756e745f6e756d6265721802200128093a0480b518011a300a064375" .
            "73746f6d120f0a0762616e6b5f6964180120012809120f0a077061796c6f" .
            "61641802200128093a0480b518011a270a054775657374120f0a0762616e" .
            "6b5f6964180120012809120d0a056e6f6e63651802200128091a2f0a0d4d" .
            "65746164617461456e747279120b0a036b6579180120012809120d0a0576" .
            "616c75651802200128093a02380142090a076163636f756e744234420d41" .
            "63636f756e7450726f746f73aa0222546f6b656e696f2e50726f746f2e43" .
            "6f6d6d6f6e2e4163636f756e7450726f746f73620670726f746f33"
        ));

        static::$is_initialized = true;
    }
}

