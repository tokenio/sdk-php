<?php

namespace Test\Tokenio\Security;

use Io\Token\Proto\Common\Alias\Alias;
use Io\Token\Proto\Common\Security\Key\Level;
use PHPUnit\Framework\TestCase;
use Test\Tokenio\TestUtil;
use Tokenio\Exception\CryptographicException;
use Tokenio\Security\CryptoEngineInterface;
use Tokenio\Security\Ed25519Verifier;
use Tokenio\Security\TokenCryptoEngine;
use Tokenio\Security\UnsecuredFileSystemKeyStore;
use Tokenio\Util\Base64Url;
use Tokenio\Util\Strings;

class CryptoEngineTest extends TestCase
{
    private $memberId;
    private $keyStore;

    /**
     * @var CryptoEngineInterface
     */
    private $cryptoEngine;

    protected function setUp()
    {
        $this->memberId = Strings::generateNonce();
        $this->keyStore = new UnsecuredFileSystemKeyStore(__DIR__ . '/test-keys/');
        $this->cryptoEngine = new TokenCryptoEngine($this->memberId, $this->keyStore);
    }

    public function testVerifier()
    {
        $signature = "tPmCXbpIf-lR2sOJrlB3wviI-mybLwKomo6Vh3Lxaf9RmS7FDiL5zdDxa8m5JvoVBMW4MnqHn5zUaKecESjjBQ";
        $payload = "{\"type\":\"EMAIL\",\"value\":\"123\"}";

        $verifier = new Ed25519Verifier(Base64Url::decode("ypQFEgdQe-E8u1dtpmAhAE0EoaGdvP5lNc0P4wgY2DA"));
        $this->assertTrue($verifier->verifyString($payload, $signature));
    }

    public function testSignAndVerifyString()
    {
        $this->cryptoEngine->generateKey(Level::PRIVILEGED);
        $signer = $this->cryptoEngine->createSigner(Level::PRIVILEGED);

        $payload = Strings::generateNonce();
        $signature = $signer->signString($payload);

        $verifier = $this->cryptoEngine->createVerifier($signer->getKeyId());
        $this->assertTrue($verifier->verifyString($payload, $signature));
    }

    public function testSignAndVerifyProtobuf()
    {
        $this->cryptoEngine->generateKey(Level::PRIVILEGED);
        $signer = $this->cryptoEngine->createSigner(Level::PRIVILEGED);

        $payload = new Alias();
        $payload->setType(Alias\Type::EMAIL);
        $payload->setValue('bob@token.io');

        $signature = $signer->sign($payload);

        $verifier = $this->cryptoEngine->createVerifier($signer->getKeyId());
        $this->assertTrue($verifier->verify($payload, $signature));
    }

    public function testWrongKey()
    {
        $this->expectException(CryptographicException::class);

        $oldKey = $this->cryptoEngine->generateKey(Level::PRIVILEGED);
        $this->cryptoEngine->generateKey(Level::PRIVILEGED);
        $signer = $this->cryptoEngine->createSigner(Level::PRIVILEGED);

        $payload = Strings::generateNonce();
        $signature = $signer->signString($payload);

        $verifier = $this->cryptoEngine->createVerifier($oldKey->getId());
        $verifier->verifyString($payload, $signature);
    }

    protected function tearDown()
    {
        TestUtil::removeDirectory(__DIR__ . '/test-keys/');
    }
}
