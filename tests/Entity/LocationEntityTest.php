<?php

namespace Fira\Test\Entity;

use Fira\Domain\Entity\LocationEntity;
use PHPUnit\Framework\TestCase;

final class LocationEntityTest extends TestCase
{
    public function testSetterAndGetters(): void
    {
        $locationEntity = new LocationEntity();
        $locationEntity->setName('hsh');

        $this->assertEquals('hsh', $locationEntity->getName());
    }
}