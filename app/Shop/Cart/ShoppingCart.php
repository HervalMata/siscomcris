<?php

namespace App\Shop\Cart;

use Illuminate\Contracts\Container\BindingResolutionException;
use Gloudemans\Shoppingcart\Cart;

class ShoppingCart extends Cart
{
    private $session;

    private $event;

    public function __construct()
    {
        $this->session = $this->getSession();
        $this->event = $this->getEvents();
        parent::__construct($this->session, $this->event);
    }

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    public function getSession()
    {
        return app()->make('session');
    }

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    public function getEvent()
    {
        return app()->make('events');
    }

}
