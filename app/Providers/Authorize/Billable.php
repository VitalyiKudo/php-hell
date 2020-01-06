<?php

namespace App\Providers\Authorize;

use Authorize;
use Exception;
use App\Models\Card;

trait Billable
{
    /**
     * Create an Authorize.Net customer for the given model.
     *
     * @return int|null
     */
    public function createAsAuthorizeCustomer()
    {
        $id = Authorize::createCustomerProfile($this);

        if (! is_null($id)) {
            $this->authorize_id = $id;

            $this->save();
        }

        return $id;
    }

    /**
     * Update the underlying Authorize.Net customer information for the model.
     *
     * @return bool
     */
    public function updateAuthorizeCustomer()
    {
        return Authorize::updateCustomerProfile($this);
    }

    /**
     * Get the Authorize.Net customer instance for the current user or create one.
     *
     * @return int|null
     */
    public function createOrGetAuthorizeCustomer()
    {
        if ($this->authorize_id) {
            return $this->authorize_id;
        }

        return $this->createAsAuthorizeCustomer();
    }

    /**
     * Add a new credit card for the user in Authorize.Net.
     *
     * @param  string  $number
     * @param  int  $year
     * @param  int  $month
     * @param  int  $cvv
     * @return int|bool
     */
    public function addCard($number, $year, $month, $cvv)
    {
        $customerId = $this->createOrGetAuthorizeCustomer();

        if (is_null($customerId)) {
            return false;
        }

        return Authorize::createPaymentProfile($customerId, $number, $year, $month, $cvv);
    }

    /**
     * Delete a specified credit card for the user in Authorize.Net.
     *
     * @param  int  $profileId
     * @return int|bool
     */
    public function deleteCard($profileId)
    {
        $customerId = $this->createOrGetAuthorizeCustomer();

        if (is_null($customerId)) {
            return false;
        }

        return Authorize::deletePaymentProfile($customerId, $profileId);
    }

    /**
     * Charge the user.
     *
     * @param  \App\Models\Card
     * @param  float  $amount
     * @return int|bool
     */
    public function charge(Card $card, float $amount)
    {
        $customerId = $this->createOrGetAuthorizeCustomer();

        if (is_null($customerId)) {
            return false;
        }

        return Authorize::charge($customerId, $card->authorize_payment_id, $amount);
    }
}
