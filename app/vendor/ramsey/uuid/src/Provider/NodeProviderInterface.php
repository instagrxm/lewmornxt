<<<<<<< HEAD
<?php

/**
 * This file is part of the ramsey/uuid library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types=1);

namespace Ramsey\Uuid\Provider;

use Ramsey\Uuid\Type\Hexadecimal;

/**
 * A node provider retrieves or generates a node ID
 */
interface NodeProviderInterface
{
    /**
     * Returns a node ID
     *
     * @return Hexadecimal The node ID as a hexadecimal string
     */
    public function getNode(): Hexadecimal;
}
=======
<?php

/**
 * This file is part of the ramsey/uuid library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types=1);

namespace Ramsey\Uuid\Provider;

use Ramsey\Uuid\Type\Hexadecimal;

/**
 * A node provider retrieves or generates a node ID
 */
interface NodeProviderInterface
{
    /**
     * Returns a node ID
     *
     * @return Hexadecimal The node ID as a hexadecimal string
     */
    public function getNode(): Hexadecimal;
}
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
