<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Brick\Math\Exception;

/**
 * Exception thrown when a division by zero occurs.
 */
class DivisionByZeroException extends MathException
{
    /**
     * @return DivisionByZeroException
     *
     * @psalm-pure
     */
    public static function divisionByZero() : DivisionByZeroException
    {
        return new self('Division by zero.');
    }

    /**
     * @return DivisionByZeroException
     *
     * @psalm-pure
     */
    public static function denominatorMustNotBeZero() : DivisionByZeroException
    {
        return new self('The denominator of a rational number cannot be zero.');
    }
}
=======
<?php

declare(strict_types=1);

namespace Brick\Math\Exception;

/**
 * Exception thrown when a division by zero occurs.
 */
class DivisionByZeroException extends MathException
{
    /**
     * @return DivisionByZeroException
     *
     * @psalm-pure
     */
    public static function divisionByZero() : DivisionByZeroException
    {
        return new self('Division by zero.');
    }

    /**
     * @return DivisionByZeroException
     *
     * @psalm-pure
     */
    public static function denominatorMustNotBeZero() : DivisionByZeroException
    {
        return new self('The denominator of a rational number cannot be zero.');
    }
}
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
