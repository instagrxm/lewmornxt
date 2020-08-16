<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Ramsey\Uuid\Test\Generator;

use Ramsey\Uuid\Generator\RandomBytesGenerator;
use Ramsey\Uuid\Generator\RandomGeneratorFactory;
use Ramsey\Uuid\Test\TestCase;

class RandomGeneratorFactoryTest extends TestCase
{
    public function testFactoryReturnsRandomBytesGenerator(): void
    {
        $generator = (new RandomGeneratorFactory())->getGenerator();

        $this->assertInstanceOf(RandomBytesGenerator::class, $generator);
    }
}
=======
<?php

declare(strict_types=1);

namespace Ramsey\Uuid\Test\Generator;

use Ramsey\Uuid\Generator\RandomBytesGenerator;
use Ramsey\Uuid\Generator\RandomGeneratorFactory;
use Ramsey\Uuid\Test\TestCase;

class RandomGeneratorFactoryTest extends TestCase
{
    public function testFactoryReturnsRandomBytesGenerator(): void
    {
        $generator = (new RandomGeneratorFactory())->getGenerator();

        $this->assertInstanceOf(RandomBytesGenerator::class, $generator);
    }
}
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
