<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Support\Exception\BadClassNameException;
use UserFrosting\Support\Exception\BadInstanceOfException;
use UserFrosting\Tests\TestSprinkle\TestServicesProviders;
use UserFrosting\Tests\TestSprinkle\TestSprinkle;

class SprinkleManagerTest extends TestCase
{
    /**
     * getSprinkles|getMainSprinkle
     */
    public function testGetSprinklesWithNoDependent(): void
    {
        $manager = new SprinkleManager(CoreStub::class);
        $sprinkles = $manager->getSprinkles();

        $this->assertCount(1, $sprinkles);
        $this->assertContainsOnlyInstancesOf(CoreStub::class, $sprinkles);
        $this->assertSame('Test Sprinkle', $sprinkles[CoreStub::class]->getName());

        // Test getMainSprinkle while at it
        $this->assertInstanceOf(CoreStub::class, $manager->getMainSprinkle());
        $this->assertSame('Test Sprinkle', $manager->getMainSprinkle()->getName());
    }

    /**
     * getSprinkles|getMainSprinkle
     */
    public function testGetSprinklesWithObject(): void
    {
        $core = new CoreStub();
        $manager = new SprinkleManager($core);
        $sprinkles = $manager->getSprinkles();

        $this->assertCount(1, $sprinkles);
        $this->assertContainsOnlyInstancesOf(CoreStub::class, $sprinkles);
        $this->assertSame('Test Sprinkle', $sprinkles[CoreStub::class]->getName());

        // Test getMainSprinkle while at it
        $this->assertInstanceOf(CoreStub::class, $manager->getMainSprinkle());
        $this->assertSame('Test Sprinkle', $manager->getMainSprinkle()->getName());
    }

    /**
     * @depends testGetSprinklesWithNoDependent
     */
    public function testGetSprinklesWithNoDependentAndObject(): void
    {
        $manager = new SprinkleManager(CoreStub::class);
        $sprinkles = $manager->getSprinkles();

        $this->assertCount(1, $sprinkles);
        $this->assertContainsOnlyInstancesOf(CoreStub::class, $sprinkles);

        // Test isAvailable while at it
        $this->assertTrue($manager->isAvailable(CoreStub::class));
        $this->assertFalse($manager->isAvailable(AdminStub::class));
    }

    /**
     * @depends testGetSprinklesWithNoDependent
     */
    public function testGetSprinklesWithManyDependent(): void
    {
        $manager = new SprinkleManager(MainStub::class);
        $sprinkles = $manager->getSprinkles();

        $this->assertSame([
            CoreStub::class,
            AdminStub::class,
            AccountStub::class,
            MainStub::class,
        ], array_keys($sprinkles));
        $this->assertInstanceOf(CoreStub::class, array_shift($sprinkles));
        $this->assertInstanceOf(AdminStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
        $this->assertInstanceOf(AccountStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
        $this->assertInstanceOf(MainStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
        $this->assertInstanceOf(MainStub::class, $manager->getMainSprinkle());

        // Test getSprinkleNames while at it
        $this->assertSame([
            CoreStub::class    => 'Test Sprinkle',
            AdminStub::class   => 'Test Sprinkle',
            AccountStub::class => 'Test Sprinkle',
            MainStub::class    => 'Main Sprinkle',
        ], $manager->getSprinklesNames());
    }

    /**
     * @depends testGetSprinklesWithManyDependent
     */
    public function testGetSprinklesWithNestedDependent(): void
    {
        $manager = new SprinkleManager(MainNestedStub::class);
        $sprinkles = $manager->getSprinkles();

        $this->assertCount(4, $sprinkles);
        $this->assertInstanceOf(CoreStub::class, array_shift($sprinkles));
        $this->assertInstanceOf(AccountStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
        $this->assertInstanceOf(AdminNestedStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
        $this->assertInstanceOf(MainNestedStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
    }

    /**
     * @depends testGetSprinklesWithNestedDependent
     */
    public function testGetSprinklesWithDuplicateSprinkles(): void
    {
        $manager = new SprinkleManager(MainDuplicateStub::class);
        $sprinkles = $manager->getSprinkles();

        $this->assertCount(4, $sprinkles);
        $this->assertInstanceOf(CoreStub::class, array_shift($sprinkles));
        $this->assertInstanceOf(AccountStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
        $this->assertInstanceOf(AdminNestedStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
        $this->assertInstanceOf(MainDuplicateStub::class, array_shift($sprinkles)); // @phpstan-ignore-line
    }

    /**
     * __construct & Exceptions
     */
    public function testConstructorWithBadSprinkleClass(): void
    {
        $this->expectException(BadInstanceOfException::class);
        new SprinkleManager(\stdClass::class); // @phpstan-ignore-line
    }

    public function testConstructorWithNonExistingClass(): void
    {
        $this->expectException(BadClassNameException::class);

        // @phpstan-ignore-next-line
        new SprinkleManager(FooBar::class);
    }

    /**
     * @depends testConstructorWithBadSprinkleClass
     * @depends testGetSprinklesWithManyDependent
     */
    public function testConstructorWithBadSprinkleClassInDependent(): void
    {
        $this->expectException(BadInstanceOfException::class);
        new SprinkleManager(NotSprinkleStub::class);
    }

    /**
     * Test Services
     */
    public function testGetServicesDefinitions(): void
    {
        $manager = new SprinkleManager(TestSprinkle::class);
        $services = $manager->getServicesDefinitions();

        $this->assertCount(1, $services);
        $this->assertArrayHasKey('testMessageGenerator', $services[0]);
    }

    /**
     * @depends testGetServicesDefinitions
     */
    public function testGetServicesDefinitionsWithBadInstance(): void
    {
        $manager = new SprinkleManager(BadInstanceOfSprinkleStub::class);
        $this->expectException(BadInstanceOfException::class);
        $manager->getServicesDefinitions();
    }

    /**
     * @depends testGetServicesDefinitions
     */
    public function testGetServicesDefinitionsWithNotFound(): void
    {
        $manager = new SprinkleManager(NotFoundStub::class);
        $this->expectException(BadClassNameException::class);
        $manager->getServicesDefinitions();
    }

    /**
     * @depends testGetServicesDefinitions
     */
    public function testGetServicesDefinitionsWithObject(): void
    {
        $manager = new SprinkleManager(ServiceSprinkleStub::class);
        $services = $manager->getServicesDefinitions();

        $this->assertCount(1, $services);
        $this->assertArrayHasKey('testMessageGenerator', $services[0]);
    }

    /**
     * @depends testGetServicesDefinitions
     */
    public function testGetServicesDefinitionsWithOverwrite(): void
    {
        $manager = new SprinkleManager(ChildServiceSprinkleStub::class);
        $services = $manager->getServicesDefinitions();

        $this->assertCount(3, $services);
    }
}

class CoreStub extends TestSprinkle
{
}

class AdminStub extends TestSprinkle
{
    public function getBakeryCommands(): array
    {
        return [
            CommandStub::class,
        ];
    }
}

class AdminNestedStub extends TestSprinkle
{
    public function getSprinkles(): array
    {
        return [
            AccountStub::class,
        ];
    }
}

class AccountStub extends TestSprinkle
{
}

class MainStub extends TestSprinkle
{
    public function getName(): string
    {
        return 'Main Sprinkle';
    }

    public function getSprinkles(): array
    {
        return [
            CoreStub::class,
            AdminStub::class,
            AccountStub::class,
        ];
    }
}

class MainNestedStub extends TestSprinkle
{
    public function getSprinkles(): array
    {
        return [
            CoreStub::class,
            AdminNestedStub::class,
        ];
    }
}

class MainDuplicateStub extends TestSprinkle
{
    public function getSprinkles(): array
    {
        return [
            CoreStub::class,
            AdminNestedStub::class,
            AccountStub::class,
        ];
    }
}

class NotSprinkleStub extends TestSprinkle
{
    public function getSprinkles(): array
    {
        return [\stdClass::class]; // @phpstan-ignore-line
    }
}

class BadInstanceOfSprinkleStub extends TestSprinkle
{
    public function getRoutes(): array
    {
        return [\stdClass::class]; // @phpstan-ignore-line
    }

    public function getServices(): array
    {
        return [\stdClass::class]; // @phpstan-ignore-line
    }

    public function getBakeryCommands(): array
    {
        return [\stdClass::class]; // @phpstan-ignore-line
    }

    public function getMiddlewares(): array
    {
        return [\stdClass::class]; // @phpstan-ignore-line
    }
}

class NotFoundStub extends TestSprinkle
{
    public function getServices(): array
    {
        return [NotFound::class]; // @phpstan-ignore-line
    }

    public function getBakeryCommands(): array
    {
        return [NotFound::class]; // @phpstan-ignore-line
    }

    public function getMiddlewares(): array
    {
        return [NotFound::class]; // @phpstan-ignore-line
    }
}

class ServiceSprinkleStub extends TestSprinkle
{
    public function getServices(): array
    {
        return [
            TestServicesProviders::class,
        ];
    }
}

class ChildServiceSprinkleStub extends TestSprinkle
{
    public function getServices(): array
    {
        return [
            OverwriteTestServicesProviders::class,
            OtherTestServicesProviders::class,
        ];
    }

    public function getSprinkles(): array
    {
        return [
            ServiceSprinkleStub::class,
        ];
    }
}

class CommandStub extends Command
{
    // @phpstan-ignore-next-line
    protected function configure()
    {
        $this->setName('stub');
    }
}

class OverwriteTestServicesProviders implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            'testMessageGenerator' => 'blah',
        ];
    }
}

class OtherTestServicesProviders implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            'foo' => 'bar',
        ];
    }
}
