<?php

namespace WTG\Checkout\Exceptions;

use Throwable;

/**
 * Quote item not found exception
 *
 * @package     WTG\Checkout
 * @subpackage  Exceptions
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class QuoteItemNotFoundException extends \Exception
{
    /**
     * QuoteItemDoesNotExistException constructor.
     *
     * @param  int  $code
     * @param  Throwable|null  $previous
     */
    public function __construct($code = 0, Throwable $previous = null)
    {
        $message = "No quote item found with the given product";

        parent::__construct($message, $code, $previous);
    }
}