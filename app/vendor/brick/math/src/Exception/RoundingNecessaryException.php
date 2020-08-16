<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Brick\Math\Exception;

/**
 * Exception thrown when a number cannot be represented at the requested scale without rounding.
 */
class RoundingNecessaryException extends MathException
{
    /**
     * @return RoundingNecessaryException
     *
     * @psalm-pure
     */
    public static function roundingNecessary() : RoundingNecessaryException
    {
        return new self('Rounding is necessary to represent the result of the operation at this scale.');
    }
}
=======
<?php

declare(strict_types=1);

namespace Brick\Math\Exception;

/**
 * Exception thrown when a number cannot be represented at the requested scale without rounding.
 */
class RoundingNecessaryException extends MathException
{
    /**
     * @return RoundingNecessaryException
     *
     * @psalm-pure
     */
    public static function roundingNecessary() : RoundingNecessaryException
    {
        return new self('Rounding is necessary to represent the result of the operation at this scale.');
    }
}
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
