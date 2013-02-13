<?php
namespace Hostnet\FormTwigBridge\Tests;

use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider;

use Hostnet\FormTwigBridge\TwigEnvironmentBuilder;

class TwigEnvironmentBuilderTest extends \PHPUnit_Framework_TestCase
{
  public function testSetCsrfProvider()
  {
    // Test chaining
    $builder = new TwigEnvironmentBuilder();
    $this->assertEquals($builder, $builder->setCsrfProvider(new DefaultCsrfProvider('foo')));
  }

  public function testSetLocale()
  {
    // Test chaining
    $builder = new TwigEnvironmentBuilder();
    $this->assertEquals($builder, $builder->setLocale('nl_NL'));
  }

  public function testBuild()
  {
    // 1. Fail without CSRF
    $builder = new TwigEnvironmentBuilder();
    $this->assertDomainExceptionAtBuild($builder, 'Missing csrf secret');

    // 2. Gives back a Twig_Environment at success
    $builder = new TwigEnvironmentBuilder();
    $builder->setCsrfProvider(new DefaultCsrfProvider('test'));
    $this->assertInstanceOf('Twig_Environment', $builder->build());
  }

  private function assertDomainExceptionAtBuild(TwigEnvironmentBuilder $builder, $message)
  {
    try {
      $builder->build();
      $this->fail($message);
    } catch(\DomainException $e) {
    }
  }
}
