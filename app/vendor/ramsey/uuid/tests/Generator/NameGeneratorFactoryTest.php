<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Ramsey\Uuid\Test\Generator;

use Ramsey\Uuid\Generator\DefaultNameGenerator;
use Ramsey\Uuid\Generator\NameGeneratorFactory;
use Ramsey\Uuid\Test\TestCase;

class NameGeneratorFactoryTest extends TestCase
{
    public function testGetGenerator(): void
    {
        $factory = new NameGeneratorFactory();

        $this->assertInstanceOf(DefaultNameGenerator::class, $factory->getGenerator());
    }
}
=======
<?php

declare(strict_types=1);

namespace Ramsey\Uuid\Test\Generator;

use Ramsey\Uuid\Generator\DefaultNameGenerator;
use Ramsey\Uuid\Generator\NameGeneratorFactory;
use Ramsey\Uuid\Test\TestCase;

class NameGeneratorFactoryTest extends TestCase
{
    public function testGetGenerator(): void
    {
        $factory = new NameGeneratorFactory();

        $this->assertInstanceOf(DefaultNameGenerator::class, $factory->getGenerator());
    }
}
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
