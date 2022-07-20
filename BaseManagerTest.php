<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use App\Managers\BaseManager;

class BaseManagerTest extends TestCase
{
    /** @test */
    public function it_retrieves_driver_from_method_name()
    {
        $newManager = $this->getMockedManager();

        $driverList = $newManager->getAvailableDrivers(true);

        $this->assertTrue(in_array('test', $driverList));
    }

    /** @test */
    public function it_retrieves_driver_from_closure()
    {
        $newManager = $this->getMockedManager();

        $newManager->extend('callback', fn () => true);

        $driverList = $newManager->getAvailableDrivers(true);

        $this->assertTrue(in_array('callback', $driverList));
    }

    /** @test */
    public function it_retrieves_driver_from_method_name_in_custom_driver_key()
    {
        TestCase::markTestIncomplete('This test is to make sure that when not results are not flattened, the driver will be returned under the correct array key.');
    }

    /** @test */
    public function it_retrieves_driver_from_closure_in_custom_driver_key()
    {
        TestCase::markTestIncomplete('This test is to make sure that when not results are not flattened, the driver will be returned under the correct array key.');
    }

    private function getMockedManager(): BaseManager
    {
        return new class (app()) extends BaseManager {
            public function getDefaultDriver(): string
            {
                return 'test';
            }

            public function getTestDriver()
            {
                return;
            }
        };
    }
}
