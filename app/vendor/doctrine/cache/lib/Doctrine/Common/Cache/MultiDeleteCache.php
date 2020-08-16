<<<<<<< HEAD
<?php

namespace Doctrine\Common\Cache;

/**
 * Interface for cache drivers that allows to put many items at once.
 *
 * @deprecated
 *
 * @link   www.doctrine-project.org
 */
interface MultiDeleteCache
{
    /**
     * Deletes several cache entries.
     *
     * @param string[] $keys Array of keys to delete from cache
     *
     * @return bool TRUE if the operation was successful, FALSE if it wasn't.
     */
    public function deleteMultiple(array $keys);
}
=======
<?php

namespace Doctrine\Common\Cache;

/**
 * Interface for cache drivers that allows to put many items at once.
 *
 * @deprecated
 *
 * @link   www.doctrine-project.org
 */
interface MultiDeleteCache
{
    /**
     * Deletes several cache entries.
     *
     * @param string[] $keys Array of keys to delete from cache
     *
     * @return bool TRUE if the operation was successful, FALSE if it wasn't.
     */
    public function deleteMultiple(array $keys);
}
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
