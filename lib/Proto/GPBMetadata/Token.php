<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: token.proto

namespace GPBMetadata;

class Token
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Blob::initOnce();
        \GPBMetadata\Money::initOnce();
        \GPBMetadata\Pricing::initOnce();
        \GPBMetadata\Security::initOnce();
        \GPBMetadata\Transfer::initOnce();
        \GPBMetadata\Transferinstructions::initOnce();
        \GPBMetadata\Alias::initOnce();
        \GPBMetadata\Extensions\Field::initOnce();
        \GPBMetadata\Extensions\Message::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0aed310a0b746f6b656e2e70726f746f121b696f2e746f6b656e2e70726f" .
            "746f2e636f6d6d6f6e2e746f6b656e1a0b6d6f6e65792e70726f746f1a0d" .
            "70726963696e672e70726f746f1a0e73656375726974792e70726f746f1a" .
            "0e7472616e736665722e70726f746f1a1a7472616e73666572696e737472" .
            "756374696f6e732e70726f746f1a0b616c6961732e70726f746f1a166578" .
            "74656e73696f6e732f6669656c642e70726f746f1a18657874656e73696f" .
            "6e732f6d6573736167652e70726f746f22d0010a05546f6b656e120a0a02" .
            "6964180120012809123a0a077061796c6f616418022001280b32292e696f" .
            "2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e546f6b65" .
            "6e5061796c6f616412470a127061796c6f61645f7369676e617475726573" .
            "18032003280b322b2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e" .
            "2e746f6b656e2e546f6b656e5369676e6174757265121c0a147265706c61" .
            "6365645f62795f746f6b656e5f696418042001280912180a10746f6b656e" .
            "5f726571756573745f696418052001280922a8030a0c546f6b656e526571" .
            "75657374120a0a02696418012001280912490a0f726571756573745f7061" .
            "796c6f616418062001280b32302e696f2e746f6b656e2e70726f746f2e63" .
            "6f6d6d6f6e2e746f6b656e2e546f6b656e526571756573745061796c6f61" .
            "6412490a0f726571756573745f6f7074696f6e7318072001280b32302e69" .
            "6f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e546f6b" .
            "656e526571756573744f7074696f6e73123e0a077061796c6f6164180220" .
            "01280b32292e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f" .
            "6b656e2e546f6b656e5061796c6f616442021801124f0a076f7074696f6e" .
            "7318032003280b32362e696f2e746f6b656e2e70726f746f2e636f6d6d6f" .
            "6e2e746f6b656e2e546f6b656e526571756573742e4f7074696f6e73456e" .
            "7472794206180180b5180112170a0b757365725f7265665f696418042001" .
            "280942021801121c0a10637573746f6d697a6174696f6e5f696418052001" .
            "2809420218011a2e0a0c4f7074696f6e73456e747279120b0a036b657918" .
            "0120012809120d0a0576616c75651802200128093a0238012294010a1354" .
            "6f6b656e526571756573744f7074696f6e73120f0a0762616e6b5f696418" .
            "012001280912360a0466726f6d18022001280b32282e696f2e746f6b656e" .
            "2e70726f746f2e636f6d6d6f6e2e746f6b656e2e546f6b656e4d656d6265" .
            "7212190a11736f757263655f6163636f756e745f69641803200128091219" .
            "0a11726563656970745f7265717565737465641804200128082288070a13" .
            "546f6b656e526571756573745061796c6f616412130a0b757365725f7265" .
            "665f696418012001280912180a10637573746f6d697a6174696f6e5f6964" .
            "18022001280912140a0c72656469726563745f75726c180320012809120e" .
            "0a067265665f6964180b2001280912340a02746f18042001280b32282e69" .
            "6f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e546f6b" .
            "656e4d656d62657212380a09616374696e675f617318052001280b32252e" .
            "696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e4163" .
            "74696e67417312520a0b6163636573735f626f647918062001280b323b2e" .
            "696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e546f" .
            "6b656e526571756573745061796c6f61642e416363657373426f64794800" .
            "12560a0d7472616e736665725f626f647918072001280b323d2e696f2e74" .
            "6f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e546f6b656e52" .
            "6571756573745061796c6f61642e5472616e73666572426f647948001219" .
            "0a0b6465736372697074696f6e180820012809420480b5180112160a0e63" .
            "616c6c6261636b5f7374617465180920012809121b0a1364657374696e61" .
            "74696f6e5f636f756e747279180a200128091aff010a0a41636365737342" .
            "6f647912560a047479706518012003280e32482e696f2e746f6b656e2e70" .
            "726f746f2e636f6d6d6f6e2e746f6b656e2e546f6b656e52657175657374" .
            "5061796c6f61642e416363657373426f64792e5265736f75726365547970" .
            "65121a0a0e7265736f757263655f74797065731802200328094202180122" .
            "7d0a0c5265736f7572636554797065120b0a07494e56414c49441000120c" .
            "0a084143434f554e54531001120c0a0842414c414e434553100212100a0c" .
            "5452414e53414354494f4e53100312190a155452414e534645525f444553" .
            "54494e4154494f4e53100412170a1346554e44535f434f4e4649524d4154" .
            "494f4e5310051a9d010a0c5472616e73666572426f647912100a08637572" .
            "72656e6379180120012809120e0a06616d6f756e7418022001280912170a" .
            "0f6c69666574696d655f616d6f756e7418042001280912520a0c64657374" .
            "696e6174696f6e7318032003280b323c2e696f2e746f6b656e2e70726f74" .
            "6f2e636f6d6d6f6e2e7472616e73666572696e737472756374696f6e732e" .
            "5472616e73666572456e64706f696e74420e0a0c726571756573745f626f" .
            "647922600a08416374696e67417312140a0c646973706c61795f6e616d65" .
            "180120012809120e0a067265665f696418022001280912100a086c6f676f" .
            "5f75726c18032001280912160a0e7365636f6e646172795f6e616d651804" .
            "200128093a0480b5180122c6010a0e546f6b656e5369676e617475726512" .
            "420a06616374696f6e18012001280e32322e696f2e746f6b656e2e70726f" .
            "746f2e636f6d6d6f6e2e746f6b656e2e546f6b656e5369676e6174757265" .
            "2e416374696f6e123c0a097369676e617475726518022001280b32292e69" .
            "6f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e73656375726974792e" .
            "5369676e617475726522320a06416374696f6e120b0a07494e56414c4944" .
            "1000120c0a08454e444f525345441001120d0a0943414e43454c4c454410" .
            "02225e0a0b546f6b656e4d656d626572120a0a0269641801200128091210" .
            "0a08757365726e616d6518022001280912310a05616c6961731803200128" .
            "0b32222e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e616c6961" .
            "732e416c69617322c3040a0c546f6b656e5061796c6f6164120f0a077665" .
            "7273696f6e180120012809120e0a067265665f696418022001280912380a" .
            "0669737375657218032001280b32282e696f2e746f6b656e2e70726f746f" .
            "2e636f6d6d6f6e2e746f6b656e2e546f6b656e4d656d62657212360a0466" .
            "726f6d18042001280b32282e696f2e746f6b656e2e70726f746f2e636f6d" .
            "6d6f6e2e746f6b656e2e546f6b656e4d656d62657212340a02746f180520" .
            "01280b32282e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f" .
            "6b656e2e546f6b656e4d656d62657212170a0f6566666563746976655f61" .
            "745f6d7318062001280312150a0d657870697265735f61745f6d73180720" .
            "01280312190a0b6465736372697074696f6e180820012809420480b51801" .
            "123d0a087472616e7366657218092001280b32292e696f2e746f6b656e2e" .
            "70726f746f2e636f6d6d6f6e2e746f6b656e2e5472616e73666572426f64" .
            "79480012390a06616363657373180a2001280b32272e696f2e746f6b656e" .
            "2e70726f746f2e636f6d6d6f6e2e746f6b656e2e416363657373426f6479" .
            "480012180a10656e646f7273655f756e74696c5f6d73180b200128031238" .
            "0a09616374696e675f6173180c2001280b32252e696f2e746f6b656e2e70" .
            "726f746f2e636f6d6d6f6e2e746f6b656e2e416374696e67417312190a11" .
            "726563656970745f726571756573746564180d2001280812180a10746f6b" .
            "656e5f726571756573745f6964180e2001280912140a0c696e6974696174" .
            "6f725f6964180f2001280942060a04626f647922620a1c45787465726e61" .
            "6c417574686f72697a6174696f6e44657461696c73120b0a0375726c1801" .
            "20012809121a0a12636f6d706c6574696f6e5f7061747465726e18022001" .
            "280912190a11617574686f72697a6174696f6e5f75726c18032001280922" .
            "db020a0c5472616e73666572426f6479123e0a0872656465656d65721801" .
            "2001280b32282e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e74" .
            "6f6b656e2e546f6b656e4d656d6265724202180112560a0c696e73747275" .
            "6374696f6e7318022001280b32402e696f2e746f6b656e2e70726f746f2e" .
            "636f6d6d6f6e2e7472616e73666572696e737472756374696f6e732e5472" .
            "616e73666572496e737472756374696f6e7312100a0863757272656e6379" .
            "18042001280912170a0f6c69666574696d655f616d6f756e741805200128" .
            "09120e0a06616d6f756e74180620012809123b0a0b6174746163686d656e" .
            "747318082003280b32262e696f2e746f6b656e2e70726f746f2e636f6d6d" .
            "6f6e2e626c6f622e4174746163686d656e74123b0a0770726963696e6718" .
            "092001280b32262e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e" .
            "70726963696e672e50726963696e674202180122ae100a0a416363657373" .
            "426f647912430a097265736f757263657318052003280b32302e696f2e74" .
            "6f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e416363657373" .
            "426f64792e5265736f757263651ada0f0a085265736f75726365124b0a07" .
            "6163636f756e7418062001280b32382e696f2e746f6b656e2e70726f746f" .
            "2e636f6d6d6f6e2e746f6b656e2e416363657373426f64792e5265736f75" .
            "7263652e4163636f756e744800125c0a0c7472616e73616374696f6e7318" .
            "072001280b32442e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e" .
            "746f6b656e2e416363657373426f64792e5265736f757263652e4163636f" .
            "756e745472616e73616374696f6e73480012520a0762616c616e63651808" .
            "2001280b323f2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e74" .
            "6f6b656e2e416363657373426f64792e5265736f757263652e4163636f75" .
            "6e7442616c616e6365480012660a157472616e736665725f64657374696e" .
            "6174696f6e73180c2001280b32452e696f2e746f6b656e2e70726f746f2e" .
            "636f6d6d6f6e2e746f6b656e2e416363657373426f64792e5265736f7572" .
            "63652e5472616e7366657244657374696e6174696f6e73480012600a1266" .
            "756e64735f636f6e6669726d6174696f6e180f2001280b32422e696f2e74" .
            "6f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e416363657373" .
            "426f64792e5265736f757263652e46756e6473436f6e6669726d6174696f" .
            "6e4800124f0a076164647265737318052001280b32382e696f2e746f6b65" .
            "6e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e416363657373426f64" .
            "792e5265736f757263652e41646472657373420218014800125a0a0d616c" .
            "6c5f61646472657373657318012001280b323d2e696f2e746f6b656e2e70" .
            "726f746f2e636f6d6d6f6e2e746f6b656e2e416363657373426f64792e52" .
            "65736f757263652e416c6c41646472657373657342021801480012580a0c" .
            "616c6c5f6163636f756e747318022001280b323c2e696f2e746f6b656e2e" .
            "70726f746f2e636f6d6d6f6e2e746f6b656e2e416363657373426f64792e" .
            "5265736f757263652e416c6c4163636f756e747342021801480012670a10" .
            "616c6c5f7472616e73616374696f6e7318032001280b32472e696f2e746f" .
            "6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e41636365737342" .
            "6f64792e5265736f757263652e416c6c4163636f756e745472616e736163" .
            "74696f6e73420218014800125f0a0c616c6c5f62616c616e636573180420" .
            "01280b32432e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f" .
            "6b656e2e416363657373426f64792e5265736f757263652e416c6c416363" .
            "6f756e7442616c616e63657342021801480012710a19616c6c5f7472616e" .
            "736665725f64657374696e6174696f6e73180d2001280b32482e696f2e74" .
            "6f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e416363657373" .
            "426f64792e5265736f757263652e416c6c5472616e736665724465737469" .
            "6e6174696f6e7342021801480012660a14616c6c5f6163636f756e74735f" .
            "61745f62616e6b18092001280b32422e696f2e746f6b656e2e70726f746f" .
            "2e636f6d6d6f6e2e746f6b656e2e416363657373426f64792e5265736f75" .
            "7263652e416c6c4163636f756e7473417442616e6b420218014800126e0a" .
            "18616c6c5f7472616e73616374696f6e735f61745f62616e6b180a200128" .
            "0b32462e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b65" .
            "6e2e416363657373426f64792e5265736f757263652e416c6c5472616e73" .
            "616374696f6e73417442616e6b42021801480012660a14616c6c5f62616c" .
            "616e6365735f61745f62616e6b180b2001280b32422e696f2e746f6b656e" .
            "2e70726f746f2e636f6d6d6f6e2e746f6b656e2e416363657373426f6479" .
            "2e5265736f757263652e416c6c42616c616e636573417442616e6b420218" .
            "014800127f0a21616c6c5f7472616e736665725f64657374696e6174696f" .
            "6e735f61745f62616e6b180e2001280b324e2e696f2e746f6b656e2e7072" .
            "6f746f2e636f6d6d6f6e2e746f6b656e2e416363657373426f64792e5265" .
            "736f757263652e416c6c5472616e7366657244657374696e6174696f6e73" .
            "417442616e6b4202180148001a1d0a074164647265737312120a0a616464" .
            "726573735f69641801200128091a1d0a074163636f756e7412120a0a6163" .
            "636f756e745f69641801200128091a290a134163636f756e745472616e73" .
            "616374696f6e7312120a0a6163636f756e745f69641801200128091a240a" .
            "0e4163636f756e7442616c616e636512120a0a6163636f756e745f696418" .
            "01200128091a2a0a145472616e7366657244657374696e6174696f6e7312" .
            "120a0a6163636f756e745f69641801200128091a270a1146756e6473436f" .
            "6e6669726d6174696f6e12120a0a6163636f756e745f6964180120012809" .
            "1a0e0a0c416c6c4164647265737365731a0d0a0b416c6c4163636f756e74" .
            "731a240a11416c6c4163636f756e7473417442616e6b120f0a0762616e6b" .
            "5f69641801200128091a180a16416c6c4163636f756e745472616e736163" .
            "74696f6e731a280a15416c6c5472616e73616374696f6e73417442616e6b" .
            "120f0a0762616e6b5f69641801200128091a140a12416c6c4163636f756e" .
            "7442616c616e6365731a240a11416c6c42616c616e636573417442616e6b" .
            "120f0a0762616e6b5f69641801200128091a190a17416c6c5472616e7366" .
            "657244657374696e6174696f6e731a300a1d416c6c5472616e7366657244" .
            "657374696e6174696f6e73417442616e6b120f0a0762616e6b5f69641801" .
            "20012809420a0a087265736f7572636522d3010a14546f6b656e4f706572" .
            "6174696f6e526573756c7412310a05746f6b656e18012001280b32222e69" .
            "6f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e546f6b" .
            "656e12480a0673746174757318022001280e32382e696f2e746f6b656e2e" .
            "70726f746f2e636f6d6d6f6e2e746f6b656e2e546f6b656e4f7065726174" .
            "696f6e526573756c742e537461747573223e0a06537461747573120b0a07" .
            "494e56414c49441000120b0a07535543434553531001121a0a164d4f5245" .
            "5f5349474e4154555245535f4e45454445441002223b0a18546f6b656e52" .
            "65717565737453746174655061796c6f616412100a08746f6b656e5f6964" .
            "180120012809120d0a05737461746518022001280922a8020a06506f6c69" .
            "6379124f0a1073696e676c655f7369676e617475726518012001280b3233" .
            "2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e50" .
            "6f6c6963792e53696e676c655369676e617475726548001a4d0a0f53696e" .
            "676c655369676e6174757265123a0a067369676e657218012001280b322a" .
            "2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e746f6b656e2e50" .
            "6f6c6963792e5369676e65721a740a065369676e657212110a096d656d62" .
            "65725f6964180120012809123c0a096b65795f6c6576656c18022001280e" .
            "32292e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e7365637572" .
            "6974792e4b65792e4c6576656c12190a11617574686f72697a6174696f6e" .
            "5f75726c18032001280942080a06706f6c6963792acd020a135472616e73" .
            "666572546f6b656e537461747573120b0a07494e56414c49441000120b0a" .
            "0753554343455353100112140a104641494c5552455f52454a4543544544" .
            "1002121e0a1a4641494c5552455f494e53554646494349454e545f46554e" .
            "44531003121c0a184641494c5552455f494e56414c49445f43555252454e" .
            "4359100412240a204641494c5552455f534f555243455f4143434f554e54" .
            "5f4e4f545f464f554e44100512290a254641494c5552455f44455354494e" .
            "4154494f4e5f4143434f554e545f4e4f545f464f554e441006121a0a1646" .
            "41494c5552455f494e56414c49445f414d4f554e54100a12190a15464149" .
            "4c5552455f494e56414c49445f51554f5445100b122b0a274641494c5552" .
            "455f45585445524e414c5f415554484f52495a4154494f4e5f5245515549" .
            "524544100c12130a0f4641494c5552455f47454e4552494310094230420b" .
            "546f6b656e50726f746f73aa0220546f6b656e696f2e50726f746f2e436f" .
            "6d6d6f6e2e546f6b656e50726f746f73620670726f746f33"
        ));

        static::$is_initialized = true;
    }
}

