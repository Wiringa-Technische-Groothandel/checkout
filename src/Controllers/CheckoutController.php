<?php

namespace WTG\Checkout\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WTG\Checkout\Requests\FinishOrderRequest;
use WTG\Checkout\Events\AfterFinishOrderEvent;
use WTG\Checkout\Events\BeforeFinishOrderEvent;

/**
 * Checkout controller
 *
 * @package     WTG\Checkout
 * @subpackage  Controllers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class CheckoutController extends Controller
{
    /**
     * Turn a quote into an order
     *
     * @param FinishOrderRequest $request
     */
    public function finish(FinishOrderRequest $request)
    {
        $quote = \Auth::user()->getQuote();

        \Event::fire(BeforeFinishOrderEvent::class, [
            "user" => \Auth::user(),
            "quote" => $quote
        ]);

        $order = $quote->toOrder();


        \Event::fire(AfterFinishOrderEvent::class, [
            "user" => \Auth::user(),
            "quote" => $quote,
            "order" => $order
        ]);
    }
}
