<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: provider/cma9.proto

namespace GPBMetadata\Provider;

class Cma9
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Extensions\Field::initOnce();
        \GPBMetadata\Extensions\Message::initOnce();
        \GPBMetadata\Address::initOnce();
        \GPBMetadata\Money::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0ad9150a1370726f76696465722f636d61392e70726f746f122b696f2e74" .
            "6f6b656e2e70726f746f2e636f6d6d6f6e2e70726f766964657273706563" .
            "696669632e636d61391a18657874656e73696f6e732f6d6573736167652e" .
            "70726f746f1a0d616464726573732e70726f746f1a0b6d6f6e65792e7072" .
            "6f746f22b6090a12436d61394163636f756e7444657461696c7312100a08" .
            "70617274795f696418012001280912140a0c70617274795f6e756d626572" .
            "180220012809125d0a0a70617274795f7479706518032001280e32492e69" .
            "6f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e70726f766964657273" .
            "706563696669632e636d61392e436d61394163636f756e7444657461696c" .
            "732e506172747954797065120c0a046e616d6518042001280912150a0d65" .
            "6d61696c5f61646472657373180520012809120d0a0570686f6e65180620" .
            "012809120e0a066d6f62696c65180720012809125c0a0761646472657373" .
            "18082003280b324b2e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e" .
            "2e70726f766964657273706563696669632e636d61392e436d6139416363" .
            "6f756e7444657461696c732e436d61394164647265737312610a0c616363" .
            "6f756e745f7479706518092001280e324b2e696f2e746f6b656e2e70726f" .
            "746f2e636f6d6d6f6e2e70726f766964657273706563696669632e636d61" .
            "392e436d61394163636f756e7444657461696c732e4163636f756e745479" .
            "706512670a0f6163636f756e745f73756274797065180a2001280e324e2e" .
            "696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e70726f7669646572" .
            "73706563696669632e636d61392e436d61394163636f756e744465746169" .
            "6c732e4163636f756e745375627479706512130a0b646573637269707469" .
            "6f6e180b200128091aa9010a0b436d61394164647265737312610a0c6164" .
            "64726573735f7479706518012001280e324b2e696f2e746f6b656e2e7072" .
            "6f746f2e636f6d6d6f6e2e70726f766964657273706563696669632e636d" .
            "61392e436d61394163636f756e7444657461696c732e4164647265737354" .
            "79706512370a076164647265737318022001280b32262e696f2e746f6b65" .
            "6e2e70726f746f2e636f6d6d6f6e2e616464726573732e41646472657373" .
            "22460a0950617274795479706512160a12494e56414c49445f5041525459" .
            "5f545950451000120c0a0844454c4547415445100112090a054a4f494e54" .
            "100212080a04534f4c451003229c010a0b41646472657373547970651218" .
            "0a14494e56414c49445f414444524553535f545950451000120c0a084255" .
            "53494e455353100112120a0e434f52524553504f4e44454e43451002120e" .
            "0a0a44454c4956455259544f1003120a0a064d41494c544f100412090a05" .
            "504f424f581005120a0a06504f5354414c1006120f0a0b5245534944454e" .
            "5449414c1007120d0a0953544154454d454e54100822530a0b4163636f75" .
            "6e745479706512180a14494e56414c49445f4143434f554e545f54595045" .
            "100012140a10425553494e4553535f4143434f554e54100112140a105045" .
            "52534f4e414c5f4143434f554e54100222a7010a0e4163636f756e745375" .
            "6274797065121b0a17494e56414c49445f4143434f554e545f5355425459" .
            "50451000120f0a0b4348415247455f434152441001120f0a0b4352454449" .
            "545f43415244100212130a0f43555252454e545f4143434f554e54100312" .
            "0a0a06454d4f4e4559100412080a044c4f414e1005120c0a084d4f525447" .
            "414745100612100a0c505245504149445f434152441007120b0a07534156" .
            "494e475310083a0480b518012299030a18436d61395374616e64696e674f" .
            "7264657244657461696c7312110a096672657175656e6379180120012809" .
            "12390a0d66697273745f7061796d656e7418022001280b32222e696f2e74" .
            "6f6b656e2e70726f746f2e636f6d6d6f6e2e6d6f6e65792e4d6f6e657912" .
            "1f0a1766697273745f7061796d656e745f646174655f74696d6518032001" .
            "280912380a0c6e6578745f7061796d656e7418042001280b32222e696f2e" .
            "746f6b656e2e70726f746f2e636f6d6d6f6e2e6d6f6e65792e4d6f6e6579" .
            "121e0a166e6578745f7061796d656e745f646174655f74696d6518052001" .
            "280912390a0d66696e616c5f7061796d656e7418062001280b32222e696f" .
            "2e746f6b656e2e70726f746f2e636f6d6d6f6e2e6d6f6e65792e4d6f6e65" .
            "79121f0a1766696e616c5f7061796d656e745f646174655f74696d651807" .
            "2001280912520a106372656469746f725f6163636f756e7418082001280b" .
            "32382e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e70726f7669" .
            "64657273706563696669632e636d61392e436173684163636f756e743a04" .
            "80b5180122480a0b436173684163636f756e7412130a0b736368656d655f" .
            "6e616d6518012001280912160a0e6964656e74696669636174696f6e1802" .
            "20012809120c0a046e616d651803200128092282020a14436d6139547261" .
            "6e736665724d6574616461746112220a1a696e737472756374696f6e5f69" .
            "64656e74696669636174696f6e18012001280912210a19656e645f746f5f" .
            "656e645f6964656e74696669636174696f6e180220012809123f0a047269" .
            "736b18032001280b32312e696f2e746f6b656e2e70726f746f2e636f6d6d" .
            "6f6e2e70726f766964657273706563696669632e636d61392e5269736b12" .
            "620a1672656d697474616e63655f696e666f726d6174696f6e1804200128" .
            "0b32422e696f2e746f6b656e2e70726f746f2e636f6d6d6f6e2e70726f76" .
            "6964657273706563696669632e636d61392e52656d697474616e6365496e" .
            "666f726d6174696f6e22300a1552656d697474616e6365496e666f726d61" .
            "74696f6e12170a097265666572656e6365180120012809420488b5180122" .
            "87020a045269736b125d0a147061796d656e745f636f6e746578745f636f" .
            "646518012001280e323f2e696f2e746f6b656e2e70726f746f2e636f6d6d" .
            "6f6e2e70726f766964657273706563696669632e636d61392e5061796d65" .
            "6e74436f6e74657874436f6465121e0a166d65726368616e745f63617465" .
            "676f72795f636f646518022001280912280a206d65726368616e745f6375" .
            "73746f6d65725f6964656e74696669636174696f6e18032001280912560a" .
            "1064656c69766572795f6164647265737318042001280b323c2e696f2e74" .
            "6f6b656e2e70726f746f2e636f6d6d6f6e2e70726f766964657273706563" .
            "696669632e636d61392e44656c69766572794164647265737322aa010a0f" .
            "44656c69766572794164647265737312140a0c616464726573735f6c696e" .
            "6518012003280912130a0b7374726565745f6e616d651802200128091217" .
            "0a0f6275696c64696e675f6e756d62657218032001280912110a09706f73" .
            "745f636f646518042001280912110a09746f776e5f6e616d651805200128" .
            "09121c0a14636f756e7472795f7375625f6469766973696f6e1806200328" .
            "09120f0a07636f756e7472791807200128092a94010a125061796d656e74" .
            "436f6e74657874436f646512200a1c494e56414c49445f5041594d454e54" .
            "5f434f4e544558545f434f4445100012100a0c42494c4c5f5041594d454e" .
            "54100112130a0f45434f4d4d455243455f474f4f4453100212160a124543" .
            "4f4d4d455243455f5345525649434553100312090a054f54484552100412" .
            "120a0e50415254595f544f5f5041525459100542334204436d6139aa022a" .
            "546f6b656e696f2e50726f746f2e436f6d6d6f6e2e50726f766964657253" .
            "706563696669632e436d6139620670726f746f33"
        ));

        static::$is_initialized = true;
    }
}

