<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: tsp/bankconfig.proto

namespace GPBMetadata\Tsp;

class Bankconfig
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Extensions\Field::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0ac51d0a147473702f62616e6b636f6e6669672e70726f746f1224696f2e" .
            "746f6b656e2e70726f746f2e636f6d6d6f6e2e7473702e62616e6b636f6e" .
            "66696722e1150a0a42616e6b436f6e666967126a0a18756b5f6f70656e5f" .
            "62616e6b696e675f7374616e6461726418012001280b32462e696f2e746f" .
            "6b656e2e70726f746f2e636f6d6d6f6e2e7473702e62616e6b636f6e6669" .
            "672e42616e6b436f6e6669672e554b4f70656e42616e6b696e675374616e" .
            "64617264480012660a166e6578745f67656e5f707364325f7374616e6461" .
            "726418022001280b32442e696f2e746f6b656e2e70726f746f2e636f6d6d" .
            "6f6e2e7473702e62616e6b636f6e6669672e42616e6b436f6e6669672e4e" .
            "65787447656e507364325374616e64617264480012610a13706f6c697368" .
            "5f6170695f7374616e6461726418032001280b32422e696f2e746f6b656e" .
            "2e70726f746f2e636f6d6d6f6e2e7473702e62616e6b636f6e6669672e42" .
            "616e6b436f6e6669672e506f6c6973684170695374616e64617264480012" .
            "6b0a1870726f76696465725f73616d706c655f7374616e64617264180420" .
            "01280b32472e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e7473" .
            "702e62616e6b636f6e6669672e42616e6b436f6e6669672e50726f766964" .
            "657253616d706c655374616e646172644800125f0a12737465745f707364" .
            "325f7374616e6461726418052001280b32412e696f2e746f6b656e2e7072" .
            "6f746f2e636f6d6d6f6e2e7473702e62616e6b636f6e6669672e42616e6b" .
            "436f6e6669672e53746574507364325374616e64617264480012650a1573" .
            "7461726c696e675f6170695f7374616e6461726418062001280b32442e69" .
            "6f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e7473702e62616e6b63" .
            "6f6e6669672e42616e6b436f6e6669672e537461726c696e674170695374" .
            "616e64617264480012610a13637a6563685f707364325f7374616e646172" .
            "6418072001280b32422e696f2e746f6b656e2e70726f746f2e636f6d6d6f" .
            "6e2e7473702e62616e6b636f6e6669672e42616e6b436f6e6669672e437a" .
            "656368507364325374616e64617264480012670a1662756461706573745f" .
            "707364325f7374616e6461726418082001280b32452e696f2e746f6b656e" .
            "2e70726f746f2e636f6d6d6f6e2e7473702e62616e6b636f6e6669672e42" .
            "616e6b436f6e6669672e4275646170657374507364325374616e64617264" .
            "480012630a14736c6f76616b5f707364325f7374616e6461726418092001" .
            "280b32432e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e747370" .
            "2e62616e6b636f6e6669672e42616e6b436f6e6669672e536c6f76616b50" .
            "7364325374616e6461726448001aaf010a1650726f766964657253616d70" .
            "6c655374616e6461726412110a09636c69656e745f696418012001280912" .
            "150a0d636c69656e745f736563726574180220012809121a0a126a77745f" .
            "7369676e696e675f6b65795f6964180320012809121d0a156a77745f7369" .
            "676e696e675f616c676f726974686d18042001280912160a0e7369676e69" .
            "6e675f6b65795f696418052001280912180a107472616e73706f72745f6b" .
            "65795f69641806200128091a9b020a15554b4f70656e42616e6b696e6753" .
            "74616e6461726412170a0f6f7267616e69736174696f6e5f696418012001" .
            "2809121d0a15736f6674776172655f73746174656d656e745f6964180220" .
            "012809121b0a1361757468656e7469636174696f6e5f7479706518032001" .
            "280912110a09636c69656e745f6964180420012809121b0a0d636c69656e" .
            "745f736563726574180520012809420480b51801121a0a126a77745f7369" .
            "676e696e675f6b65795f6964180620012809121d0a156a77745f7369676e" .
            "696e675f616c676f726974686d18072001280912160a0e7369676e696e67" .
            "5f6b65795f696418082001280912180a107472616e73706f72745f6b6579" .
            "5f696418092001280912100a0869735f6569646173180a200128081acb02" .
            "0a134e65787447656e507364325374616e6461726412150a0d785f617069" .
            "5f6b65795f61697318012001280912150a0d785f6170695f6b65795f7069" .
            "7318022001280912110a09636c69656e745f696418032001280912150a0d" .
            "636c69656e745f736563726574180420012809121d0a157073755f636f72" .
            "706f726174655f69645f7479706518052001280912130a0b7073755f6964" .
            "5f74797065180620012809121a0a126a77745f7369676e696e675f6b6579" .
            "5f6964180720012809121d0a156a77745f7369676e696e675f616c676f72" .
            "6974686d180820012809121d0a11717365616c5f63657274696669636174" .
            "6518092001280942021801121c0a10717761635f63657274696669636174" .
            "65180a200128094202180112160a0e7369676e696e675f6b65795f696418" .
            "0b2001280912180a107472616e73706f72745f6b65795f6964180c200128" .
            "091aa9010a1053746574507364325374616e6461726412110a09636c6965" .
            "6e745f696418012001280912150a0d636c69656e745f7365637265741802" .
            "20012809121a0a126a77745f7369676e696e675f6b65795f696418032001" .
            "2809121d0a156a77745f7369676e696e675f616c676f726974686d180420" .
            "01280912160a0e7369676e696e675f6b65795f696418052001280912180a" .
            "107472616e73706f72745f6b65795f69641806200128091adb010a11506f" .
            "6c6973684170695374616e6461726412110a09636c69656e745f69641801" .
            "2001280912150a0d636c69656e745f73656372657418022001280912160a" .
            "0e7369676e696e675f6b65795f696418032001280912180a107472616e73" .
            "706f72745f6b65795f6964180420012809121a0a126a77745f7369676e69" .
            "6e675f6b65795f6964180520012809120b0a03783575180620012809120f" .
            "0a0378356318072001280942021801120f0a037835741808200128094202" .
            "1801120f0a036b696418092001280942021801120e0a067470705f696418" .
            "0a200128091aad010a13537461726c696e674170695374616e6461726412" .
            "150a0d6169735f636c69656e745f696418012001280912190a116169735f" .
            "636c69656e745f73656372657418022001280912150a0d7069735f636c69" .
            "656e745f696418032001280912190a117069735f636c69656e745f736563" .
            "726574180420012809121a0a126a77745f7369676e696e675f6b65795f69" .
            "6418052001280912160a0e7369676e696e675f6b65795f69641806200128" .
            "091adc010a11437a656368507364325374616e6461726412110a09785f61" .
            "70695f6b657918012001280912110a09636c69656e745f69641802200128" .
            "0912150a0d636c69656e745f736563726574180320012809121a0a126a77" .
            "745f7369676e696e675f6b65795f6964180420012809121d0a156a77745f" .
            "7369676e696e675f616c676f726974686d180520012809121d0a11717365" .
            "616c5f63657274696669636174651806200128094202180112160a0e7369" .
            "676e696e675f6b65795f696418072001280912180a107472616e73706f72" .
            "745f6b65795f69641808200128091a6b0a14427564617065737450736432" .
            "5374616e6461726412110a09636c69656e745f696418012001280912160a" .
            "0e7369676e696e675f6b65795f696418022001280912180a107472616e73" .
            "706f72745f6b65795f6964180320012809120e0a067470705f6964180420" .
            "0128091a87010a12536c6f76616b507364325374616e6461726412110a09" .
            "636c69656e745f696418012001280912150a0d636c69656e745f73656372" .
            "657418022001280912150a0d7470705f636c69656e745f69641803200128" .
            "0912160a0e7369676e696e675f6b65795f696418042001280912180a1074" .
            "72616e73706f72745f6b65795f696418052001280942080a06636f6e6669" .
            "6722da060a13526567697374726174696f6e5061796c6f616412730a1875" .
            "6b5f6f70656e5f62616e6b696e675f7374616e6461726418012001280b32" .
            "4f2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e7473702e6261" .
            "6e6b636f6e6669672e526567697374726174696f6e5061796c6f61642e55" .
            "4b4f70656e42616e6b696e675374616e646172644800126f0a166e657874" .
            "5f67656e5f707364325f7374616e6461726418022001280b324d2e696f2e" .
            "746f6b656e2e70726f746f2e636f6d6d6f6e2e7473702e62616e6b636f6e" .
            "6669672e526567697374726174696f6e5061796c6f61642e4e6578744765" .
            "6e507364325374616e64617264480012680a12737465745f707364325f73" .
            "74616e6461726418032001280b324a2e696f2e746f6b656e2e70726f746f" .
            "2e636f6d6d6f6e2e7473702e62616e6b636f6e6669672e52656769737472" .
            "6174696f6e5061796c6f61642e53746574507364325374616e6461726448" .
            "001a84010a15554b4f70656e42616e6b696e675374616e64617264120b0a" .
            "0373736118012001280912160a0e7369676e696e675f6b65795f69641802" .
            "2001280912180a107472616e73706f72745f6b65795f6964180320012809" .
            "121a0a126a77745f7369676e696e675f6b65795f69641804200128091210" .
            "0a0869735f65696461731805200128081aa0010a134e65787447656e5073" .
            "64325374616e6461726412180a107472616e73706f72745f6b65795f6964" .
            "18012001280912160a0e7369676e696e675f6b65795f6964180220012809" .
            "12150a0d63616c6c6261636b5f75726c7318032003280912150a0d636f6e" .
            "746163745f656d61696c18042001280912100a086170705f6e616d651805" .
            "2001280912170a0f6170705f6465736372697074696f6e1806200128091a" .
            "bd010a1053746574507364325374616e6461726412180a107472616e7370" .
            "6f72745f6b65795f696418012001280912160a0e7369676e696e675f6b65" .
            "795f696418022001280912150a0d63616c6c6261636b5f75726c73180320" .
            "03280912100a08636f6e746163747318042003280912100a086170705f6e" .
            "616d6518052001280912170a0f6170705f6465736372697074696f6e1806" .
            "20012809120d0a0573636f706518072001280912140a0c7470705f6c6567" .
            "616c5f696418082001280942090a077061796c6f6164423e421042616e6b" .
            "436f6e66696750726f746f73aa0229546f6b656e696f2e50726f746f2e43" .
            "6f6d6d6f6e2e5473702e42616e6b436f6e66696750726f746f7362067072" .
            "6f746f33"
        ));

        static::$is_initialized = true;
    }
}

