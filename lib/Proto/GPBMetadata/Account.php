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
            "0ac91b0a0d6163636f756e742e70726f746f121d696f2e746f6b656e2e70" .
            "726f746f2e636f6d6d6f6e2e6163636f756e741a16657874656e73696f6e" .
            "732f6669656c642e70726f746f1a18657874656e73696f6e732f6d657373" .
            "6167652e70726f746f1a1670726f766964657273706563696669632e7072" .
            "6f746f22a5010a1a506c61696e7465787442616e6b417574686f72697a61" .
            "74696f6e12110a096d656d6265725f6964180120012809121a0a0c616363" .
            "6f756e745f6e616d65180220012809420480b5180112410a076163636f75" .
            "6e7418032001280b322a2e696f2e746f6b656e2e70726f746f2e636f6d6d" .
            "6f6e2e6163636f756e742e42616e6b4163636f756e74420480b518011215" .
            "0a0d65787069726174696f6e5f6d7318042001280322b2010a0f4163636f" .
            "756e744665617475726573121c0a10737570706f7274735f7061796d656e" .
            "7418012001280842021801121c0a14737570706f7274735f696e666f726d" .
            "6174696f6e18022001280812220a1672657175697265735f65787465726e" .
            "616c5f6175746818032001280842021801121d0a15737570706f7274735f" .
            "73656e645f7061796d656e7418042001280812200a18737570706f727473" .
            "5f726563656976655f7061796d656e7418052001280822ba040a0e416363" .
            "6f756e7444657461696c7312120a0a6964656e7469666965721801200128" .
            "0912470a047479706518022001280e32392e696f2e746f6b656e2e70726f" .
            "746f2e636f6d6d6f6e2e6163636f756e742e4163636f756e744465746169" .
            "6c732e4163636f756e7454797065120e0a06737461747573180320012809" .
            "12530a086d6574616461746118042003280b323b2e696f2e746f6b656e2e" .
            "70726f746f2e636f6d6d6f6e2e6163636f756e742e4163636f756e744465" .
            "7461696c732e4d65746164617461456e747279420480b5180112600a1870" .
            "726f76696465725f6163636f756e745f64657461696c7318052001280b32" .
            "3e2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e70726f766964" .
            "657273706563696669632e50726f76696465724163636f756e7444657461" .
            "696c73120b0a03626963180620012809124d0a136163636f756e745f6964" .
            "656e7469666965727318072003280b32302e696f2e746f6b656e2e70726f" .
            "746f2e636f6d6d6f6e2e6163636f756e742e4163636f756e744964656e74" .
            "696669657212210a136163636f756e745f686f6c6465725f6e616d651808" .
            "20012809420480b518011a2f0a0d4d65746164617461456e747279120b0a" .
            "036b6579180120012809120d0a0576616c75651802200128093a02380122" .
            "540a0b4163636f756e7454797065120b0a07494e56414c4944100012090a" .
            "054f544845521001120c0a08434845434b494e471002120b0a0753415649" .
            "4e4753100312080a044c4f414e100412080a0443415244100522a3020a07" .
            "4163636f756e74120a0a02696418012001280912120a046e616d65180220" .
            "012809420480b51801120f0a0762616e6b5f696418032001280912110a09" .
            "69735f6c6f636b656418052001280812480a106163636f756e745f666561" .
            "747572657318062001280b322e2e696f2e746f6b656e2e70726f746f2e63" .
            "6f6d6d6f6e2e6163636f756e742e4163636f756e74466561747572657312" .
            "200a146c6173745f63616368655f7570646174655f6d7318072001280342" .
            "02180112200a146e6578745f63616368655f7570646174655f6d73180820" .
            "0128034202180112460a0f6163636f756e745f64657461696c7318092001" .
            "280b322d2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e616363" .
            "6f756e742e4163636f756e7444657461696c7322da0c0a0b42616e6b4163" .
            "636f756e7412410a05746f6b656e18012001280b32302e696f2e746f6b65" .
            "6e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b416363" .
            "6f756e742e546f6b656e480012600a13746f6b656e5f617574686f72697a" .
            "6174696f6e18022001280b323d2e696f2e746f6b656e2e70726f746f2e63" .
            "6f6d6d6f6e2e6163636f756e742e42616e6b4163636f756e742e546f6b65" .
            "6e417574686f72697a6174696f6e42021801480012450a05737769667418" .
            "032001280b32302e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e" .
            "6163636f756e742e42616e6b4163636f756e742e53776966744202180148" .
            "0012430a047365706118042001280b322f2e696f2e746f6b656e2e70726f" .
            "746f2e636f6d6d6f6e2e6163636f756e742e42616e6b4163636f756e742e" .
            "5365706142021801480012410a0361636818052001280b322e2e696f2e74" .
            "6f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b" .
            "4163636f756e742e41636842021801480012430a0462616e6b1806200128" .
            "0b322f2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f" .
            "756e742e42616e6b4163636f756e742e42616e6b42021801480012580a0f" .
            "6661737465725f7061796d656e747318092001280b32392e696f2e746f6b" .
            "656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b4163" .
            "636f756e742e4661737465725061796d656e747342021801480012430a06" .
            "637573746f6d180a2001280b32312e696f2e746f6b656e2e70726f746f2e" .
            "636f6d6d6f6e2e6163636f756e742e42616e6b4163636f756e742e437573" .
            "746f6d480012450a056775657374180b2001280b32302e696f2e746f6b65" .
            "6e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b416363" .
            "6f756e742e4775657374420218014800123f0a046962616e180c2001280b" .
            "322f2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f75" .
            "6e742e42616e6b4163636f756e742e4962616e480012470a08646f6d6573" .
            "746963180d2001280b32332e696f2e746f6b656e2e70726f746f2e636f6d" .
            "6d6f6e2e6163636f756e742e42616e6b4163636f756e742e446f6d657374" .
            "6963480012500a086d6574616461746118072003280b32382e696f2e746f" .
            "6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e42616e6b41" .
            "63636f756e742e4d65746164617461456e747279420480b5180112480a10" .
            "6163636f756e745f666561747572657318082001280b322e2e696f2e746f" .
            "6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e742e4163636f75" .
            "6e7446656174757265731a2e0a05546f6b656e12110a096d656d6265725f" .
            "696418012001280912120a0a6163636f756e745f69641802200128091a27" .
            "0a044962616e120b0a03626963180120012809120c0a046962616e180220" .
            "0128093a0480b518011a4c0a08446f6d657374696312110a0962616e6b5f" .
            "636f646518012001280912160a0e6163636f756e745f6e756d6265721802" .
            "20012809120f0a07636f756e7472791803200128093a0480b518011a300a" .
            "06437573746f6d120f0a0762616e6b5f6964180120012809120f0a077061" .
            "796c6f61641802200128093a0480b518011a270a054775657374120f0a07" .
            "62616e6b5f6964180120012809120d0a056e6f6e63651802200128091a1b" .
            "0a0442616e6b120f0a0762616e6b5f69641801200128093a0218011a5b0a" .
            "12546f6b656e417574686f72697a6174696f6e12410a0d617574686f7269" .
            "7a6174696f6e18012001280b322a2e696f2e746f6b656e2e70726f746f2e" .
            "62616e6b6c696e6b2e42616e6b417574686f72697a6174696f6e3a021801" .
            "1a290a0453657061120c0a046962616e180120012809120b0a0362696318" .
            "02200128093a06180180b518011a2f0a03416368120f0a07726f7574696e" .
            "67180120012809120f0a076163636f756e741802200128093a06180180b5" .
            "18011a430a0e4661737465725061796d656e747312110a09736f72745f63" .
            "6f646518012001280912160a0e6163636f756e745f6e756d626572180220" .
            "0128093a06180180b518011a2d0a055377696674120b0a03626963180120" .
            "012809120f0a076163636f756e741802200128093a06180180b518011a2f" .
            "0a0d4d65746164617461456e747279120b0a036b6579180120012809120d" .
            "0a0576616c75651802200128093a02380142090a076163636f756e7422f3" .
            "030a114163636f756e744964656e74696669657212470a05746f6b656e18" .
            "012001280b32362e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e" .
            "6163636f756e742e4163636f756e744964656e7469666965722e546f6b65" .
            "6e480012450a046962616e18022001280b32352e696f2e746f6b656e2e70" .
            "726f746f2e636f6d6d6f6e2e6163636f756e742e4163636f756e74496465" .
            "6e7469666965722e4962616e480012450a046262616e18032001280b3235" .
            "2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6163636f756e74" .
            "2e4163636f756e744964656e7469666965722e4262616e480012520a0b67" .
            "625f646f6d657374696318042001280b323b2e696f2e746f6b656e2e7072" .
            "6f746f2e636f6d6d6f6e2e6163636f756e742e4163636f756e744964656e" .
            "7469666965722e4762446f6d657374696348001a2e0a05546f6b656e1211" .
            "0a096d656d6265725f696418012001280912120a0a6163636f756e745f69" .
            "641802200128091a1a0a044962616e120c0a046962616e1801200128093a" .
            "0480b518011a1a0a044262616e120c0a046262616e1801200128093a0480" .
            "b518011a3d0a0a4762446f6d657374696312110a09736f72745f636f6465" .
            "18012001280912160a0e6163636f756e745f6e756d626572180220012809" .
            "3a0480b51801420c0a0a6964656e7469666965724234420d4163636f756e" .
            "7450726f746f73aa0222546f6b656e696f2e50726f746f2e436f6d6d6f6e" .
            "2e4163636f756e7450726f746f73620670726f746f33"
        ));

        static::$is_initialized = true;
    }
}

