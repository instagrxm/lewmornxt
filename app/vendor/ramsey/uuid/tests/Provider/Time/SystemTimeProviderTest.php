<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Ramsey\Uuid\Test\Provider\Time;

use Ramsey\Uuid\Provider\Time\SystemTimeProvider;
use Ramsey\Uuid\Test\TestCase;
use Ramsey\Uuid\Type\Time;

class SystemTimeProviderTest extends TestCase
{
    public function testGetTimeUses(): void
    {
        $provider = new SystemTimeProvider();
        $time = $provider->getTime();

        $this->assertInstanceOf(Time::class, $time);
    }
}
=======
<?php

declare(strict_types=1);

namespace Ramsey\Uuid\Test\Provider\Time;

use Ramsey\Uuid\Provider\Time\SystemTimeProvider;
use Ramsey\Uuid\Test\TestCase;
use Ramsey\Uuid\Type\Time;

class SystemTimeProviderTest extends TestCase
{
    public function testGetTimeUses(): void
    {
        $provider = new SystemTimeProvider();
        $time = $provider->getTime();

        $this->assertInstanceOf(Time::class, $time);
    }
}
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
