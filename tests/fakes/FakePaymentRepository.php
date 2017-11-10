<?php
/**
 * Copyright 2017 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class FakePaymentRepository implements IPaymentRepository
{
    /**
     * @var CreditCost
     */
    public $_LastCost;
    /**
     * @var CreditCost
     */
    public $_CreditCost;
    /**
     * @var PayPalGateway
     */
    public $_LastPayPal;
    /**
     * @var StripeGateway
     */
    public $_LastStripe;
    /**
     * @var PayPalGateway
     */
    public $_PayPal;
    /**
     * @var StripeGateway
     */
    public $_Stripe;
    /**
     * @var PayPalPaymentResult
     */
    public $_LastSavedPayPalResult;

    public function __construct()
    {
        $this->_PayPal = new PayPalGateway(false, null, null, null);
        $this->_Stripe = new StripeGateway(false, null, null);
        $this->_CreditCost = new CreditCost();
    }

    public function UpdateCreditCost(CreditCost $cost)
    {
        $this->_LastCost = $cost;
    }

    public function GetCreditCost()
    {
        return $this->_CreditCost;
    }

    public function UpdatePayPalGateway(PayPalGateway $gateway)
    {
        $this->_LastPayPal = $gateway;
    }

    public function UpdateStripeGateway(StripeGateway $gateway)
    {
        $this->_LastStripe = $gateway;
    }

    public function GetPayPalGateway()
    {
        return $this->_PayPal;
    }

    public function GetStripeGateway()
    {
        return $this->_Stripe;
    }

    public function SavePayPalPaymentResult(PayPalPaymentResult $result)
    {
        $this->_LastSavedPayPalResult;
    }
}