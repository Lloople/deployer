<?php


namespace Tests;


use Deployer\Configuration;


class ConfigurationTest extends TestCase
{

    /**
     * @var Configuration
     */
    private $configuration;


    public function setUp()
    {
        parent::setUp();
        $this->configuration = Configuration::instance();
    }

    /** @test */
    public function can_generate_configuration_instance()
    {
        $this->assertInstanceOf(Configuration::class, $this->configuration);
    }

    /** @test */
    public function can_add_multiple_keys_to_configuration()
    {
        $this->configuration->set('foo', 'bar');

        $this->assertEquals('bar', $this->configuration->get('foo'));

        $this->configuration->set('best.super.hero.ever', 'Spiderman');

        $this->assertInternalType('array', $this->configuration->get('best'));

        $this->assertInternalType('array', $this->configuration->get('best.super'));

        $this->assertInternalType('array', $this->configuration->get('best.super.hero'));

        $this->assertInternalType('string', $this->configuration->get('best.super.hero.ever'));

        $this->assertEquals('Spiderman', $this->configuration->get('best.super.hero.ever'));

        $this->assertEquals(['super' => ['hero' => ['ever' => 'Spiderman']]], $this->configuration->get('best'));
    }

    /** @test */
    public function can_retrieve_default_configuration()
    {
        $this->assertEquals('defaultValue', $this->configuration->get('thisKeyDoesNotExist', 'defaultValue'));
        $this->assertEquals('', $this->configuration->get('thisKeyAlsoDoesNotExist', ''));
    }
}
