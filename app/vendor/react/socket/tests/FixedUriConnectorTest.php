<<<<<<< HEAD
<?php

namespace React\Tests\Socket;

use React\Socket\FixedUriConnector;
use React\Tests\Socket\TestCase;

class FixedUriConnectorTest extends TestCase
{
    public function testWillInvokeGivenConnector()
    {
        $base = $this->getMockBuilder('React\Socket\ConnectorInterface')->getMock();
        $base->expects($this->once())->method('connect')->with('test')->willReturn('ret');

        $connector = new FixedUriConnector('test', $base);

        $this->assertEquals('ret', $connector->connect('ignored'));
    }
}
=======
<?php

namespace React\Tests\Socket;

use React\Socket\FixedUriConnector;
use React\Tests\Socket\TestCase;

class FixedUriConnectorTest extends TestCase
{
    public function testWillInvokeGivenConnector()
    {
        $base = $this->getMockBuilder('React\Socket\ConnectorInterface')->getMock();
        $base->expects($this->once())->method('connect')->with('test')->willReturn('ret');

        $connector = new FixedUriConnector('test', $base);

        $this->assertEquals('ret', $connector->connect('ignored'));
    }
}
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
