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
            "0abe160a0d6163636f756e742e70726f746f121d696f2e746f6b656e2e70" .
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
            "5f7061796d656e7418052001280822bb030a0e4163636f756e7444657461" .
            "696c7312120a0a6964656e74696669657218012001280912470a04747970" .
            "6518022001280e32392e696f2e746f6b656e2e70726f746f2e636f6d6d6f" .
            "6e2e6163636f756e742e4163636f756e7444657461696c732e4163636f75" .
            "6e7454797065120e0a0673746174757318032001280912530a086d657461" .
            "6461746118042003280b323b2e696f2e746f6b656e2e70726f746f2e636f" .
            "6d6d6f6e2e6163636f756e742e4163636f756e7444657461696c732e4d65" .
            "746164617461456e747279420480b5180112600a1870726f76696465725f" .
            "6163636f756e745f64657461696c7318052001280b323e2e696f2e746f6b" .
            "656e2e70726f746f2e636f6d6d6f6e2e70726f7669646572737065636966" .
            "69632e50726f76696465724163636f756e7444657461696c731a2f0a0d4d" .
            "65746164617461456e747279120b0a036b6579180120012809120d0a0576" .
            "616c75651802200128093a02380122540a0b4163636f756e745479706512" .
            "0b0a07494e56414c4944100012090a054f544845521001120c0a08434845" .
            "434b494e471002120b0a07534156494e4753100312080a044c4f414e1004" .
            "12080a04434152441005229b020a074163636f756e74120a0a0269641801" .
            "2001280912120a046e616d65180220012809420480b51801120f0a076261" .
            "6e6b5f696418032001280912110a0969735f6c6f636b6564180520012808" .
            "12480a106163636f756e745f666561747572657318062001280b322e2e69" .
            "6f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e41" .
            "63636f756e744665617475726573121c0a146c6173745f63616368655f75" .
            "70646174655f6d73180720012803121c0a146e6578745f63616368655f75" .
            "70646174655f6d7318082001280312460a0f6163636f756e745f64657461" .
            "696c7318092001280b322d2e696f2e746f6b656e2e70726f746f2e636f6d" .
            "6d6f6e2e6163636f756e742e4163636f756e7444657461696c7322d40c0a" .
            "0b42616e6b4163636f756e7412410a05746f6b656e18012001280b32302e" .
            "696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e" .
            "42616e6b4163636f756e742e546f6b656e480012600a13746f6b656e5f61" .
            "7574686f72697a6174696f6e18022001280b323d2e696f2e746f6b656e2e" .
            "70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b4163636f75" .
            "6e742e546f6b656e417574686f72697a6174696f6e42021801480012450a" .
            "05737769667418032001280b32302e696f2e746f6b656e2e70726f746f2e" .
            "636f6d6d6f6e2e6163636f756e742e42616e6b4163636f756e742e537769" .
            "667442021801480012430a047365706118042001280b322f2e696f2e746f" .
            "6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b41" .
            "63636f756e742e5365706142021801480012410a0361636818052001280b" .
            "322e2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f75" .
            "6e742e42616e6b4163636f756e742e41636842021801480012430a046261" .
            "6e6b18062001280b322f2e696f2e746f6b656e2e70726f746f2e636f6d6d" .
            "6f6e2e6163636f756e742e42616e6b4163636f756e742e42616e6b420218" .
            "01480012580a0f6661737465725f7061796d656e747318092001280b3239" .
            "2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e74" .
            "2e42616e6b4163636f756e742e4661737465725061796d656e7473420218" .
            "01480012430a06637573746f6d180a2001280b32312e696f2e746f6b656e" .
            "2e70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b4163636f" .
            "756e742e437573746f6d480012410a056775657374180b2001280b32302e" .
            "696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e" .
            "42616e6b4163636f756e742e47756573744800123f0a046962616e180c20" .
            "01280b322f2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163" .
            "636f756e742e42616e6b4163636f756e742e4962616e480012470a08646f" .
            "6d6573746963180d2001280b32332e696f2e746f6b656e2e70726f746f2e" .
            "636f6d6d6f6e2e6163636f756e742e42616e6b4163636f756e742e446f6d" .
            "6573746963480012500a086d6574616461746118072003280b32382e696f" .
            "2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e4261" .
            "6e6b4163636f756e742e4d65746164617461456e747279420480b5180112" .
            "480a106163636f756e745f666561747572657318082001280b322e2e696f" .
            "2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e4163" .
            "636f756e7446656174757265731a2e0a05546f6b656e12110a096d656d62" .
            "65725f696418012001280912120a0a6163636f756e745f69641802200128" .
            "091a2b0a055377696674120b0a03626963180120012809120f0a07616363" .
            "6f756e741802200128093a0480b518011a270a044962616e120b0a036269" .
            "63180120012809120c0a046962616e1802200128093a0480b518011a4c0a" .
            "08446f6d657374696312110a0962616e6b5f636f64651801200128091216" .
            "0a0e6163636f756e745f6e756d626572180220012809120f0a07636f756e" .
            "7472791803200128093a0480b518011a300a06437573746f6d120f0a0762" .
            "616e6b5f6964180120012809120f0a077061796c6f61641802200128093a" .
            "0480b518011a270a054775657374120f0a0762616e6b5f69641801200128" .
            "09120d0a056e6f6e63651802200128091a1b0a0442616e6b120f0a076261" .
            "6e6b5f69641801200128093a0218011a5b0a12546f6b656e417574686f72" .
            "697a6174696f6e12410a0d617574686f72697a6174696f6e18012001280b" .
            "322a2e696f2e746f6b656e2e70726f746f2e62616e6b6c696e6b2e42616e" .
            "6b417574686f72697a6174696f6e3a0218011a290a0453657061120c0a04" .
            "6962616e180120012809120b0a036269631802200128093a06180180b518" .
            "011a2f0a03416368120f0a07726f7574696e67180120012809120f0a0761" .
            "63636f756e741802200128093a06180180b518011a430a0e466173746572" .
            "5061796d656e747312110a09736f72745f636f646518012001280912160a" .
            "0e6163636f756e745f6e756d6265721802200128093a06180180b518011a" .
            "2f0a0d4d65746164617461456e747279120b0a036b657918012001280912" .
            "0d0a0576616c75651802200128093a02380142090a076163636f756e7442" .
            "34420d4163636f756e7450726f746f73aa0222546f6b656e696f2e50726f" .
            "746f2e436f6d6d6f6e2e4163636f756e7450726f746f73620670726f746f" .
            "33"
        ));

        static::$is_initialized = true;
    }
}

