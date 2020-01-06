<?php

namespace App\Providers\Authorize;

use App\User;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerProfilePaymentType;
use net\authorize\api\contract\v1\PaymentProfileType;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\contract\v1\CustomerProfileType;
use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\contract\v1\CustomerProfileExType;
use net\authorize\api\contract\v1\CustomerPaymentProfileType;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\CreateCustomerProfileRequest;
use net\authorize\api\contract\v1\UpdateCustomerProfileRequest;
use net\authorize\api\controller\CreateCustomerProfileController;
use net\authorize\api\controller\UpdateCustomerProfileController;
use net\authorize\api\contract\v1\CreateCustomerPaymentProfileRequest;
use net\authorize\api\contract\v1\DeleteCustomerPaymentProfileRequest;
use net\authorize\api\controller\CreateCustomerPaymentProfileController;
use net\authorize\api\controller\DeleteCustomerPaymentProfileController;
use net\authorize\api\controller\CreateTransactionController;

class Anet
{
    /**
     * The login ID for the API.
     *
     * @var string
     */
    protected $loginId;

    /**
     * The transaction key for the API.
     *
     * @var string
     */
    protected $transactionKey;

    /**
     * Create a new Authorize client instance.
     *
     * @param  string  $loginId
     * @param  string  $transactionKey
     * @return void
     */
    public function __construct($loginId, $transactionKey)
    {
        $this->loginId = $loginId;
        $this->transactionKey = $transactionKey;
    }

    /**
     * Get the  Authorize API authentication instance.
     *
     * @return \net\authorize\api\contract\v1\MerchantAuthenticationType
     */
    public function getAuthentication()
    {
        $authentication = new MerchantAuthenticationType();

        $authentication->setName($this->loginId);
        $authentication->setTransactionKey($this->transactionKey);

        return $authentication;
    }

    /**
     * Create a new customer profile in the Authorize.Net.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function createCustomerProfile(User $user)
    {
        $customer = new CustomerProfileType();

        $customer->setMerchantCustomerId($user->id);
        $customer->setEmail($user->email);
        $customer->setDescription($user->full_name);

        // Assemble the complete transaction request
        $request = new CreateCustomerProfileRequest();

        $request->setMerchantAuthentication($this->getAuthentication());
        $request->setProfile($customer);

        // Send request to API
        $controller = new CreateCustomerProfileController($request);

        $response = $controller->executeWithApiResponse(ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == 'Ok')) {
            return $response->getCustomerProfileId();
        }

        return null;
    }

    /**
     * Update an existing customer profile in the Authorize.Net.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function updateCustomerProfile(User $user)
    {
        $customer = new CustomerProfileExType();

        $customer->setCustomerProfileId($user->authorize_id);
        $customer->setMerchantCustomerId($user->id);
        $customer->setEmail($user->email);
        $customer->setDescription($user->full_name);

        // Assemble the complete transaction request
        $request = new UpdateCustomerProfileRequest();

        $request->setMerchantAuthentication($this->getAuthentication());
        $request->setProfile($customer);

        // Send request to API
        $controller = new UpdateCustomerProfileController($request);

        $response = $controller->executeWithApiResponse(ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == 'Ok')) {
            return true;
        }

        return false;
    }

    /**
     * Create a new payment profile in the Authorize.Net.
     *
     * @param  int  $customerId
     * @param  string  $number
     * @param  int  $year
     * @param  int  $month
     * @param  int  $cvv
     * @return void
     */
    public function createPaymentProfile($customerId, $number, $year, $month, $cvv)
    {
        $card = new CreditCardType();
        $card->setCardNumber($number);
        $card->setExpirationDate("{$year}-{$month}");
        $card->setCardCode($cvv);

        $paymentCard = new PaymentType();
        $paymentCard->setCreditCard($card);

        // Create a new profile
        $profile = new CustomerPaymentProfileType();

        $profile->setCustomerType('individual');
        $profile->setPayment($paymentCard);

        // Assemble the complete transaction request
        $request = new CreateCustomerPaymentProfileRequest();

        $request->setMerchantAuthentication($this->getAuthentication());
        $request->setCustomerProfileId($customerId);
        $request->setPaymentProfile($profile);

        // Send request to API
        $controller = new CreateCustomerPaymentProfileController($request);

        $response = $controller->executeWithApiResponse(ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == 'Ok')) {
            return $response->getCustomerPaymentProfileId();
        }

        return false;
    }

    /**
     * Delete the specified payment profile in the Authorize.Net.
     *
     * @param  int  $customerId
     * @param  int  $profileId
     * @return void
     */
    public function deletePaymentProfile($customerId, $profileId)
    {
        // Assemble the complete transaction request
        $request = new DeleteCustomerPaymentProfileRequest();

        $request->setMerchantAuthentication($this->getAuthentication());
        $request->setCustomerProfileId($customerId);
        $request->setCustomerPaymentProfileId($profileId);

        // Send request to API
        $controller = new DeleteCustomerPaymentProfileController($request);

        $response = $controller->executeWithApiResponse(ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == 'Ok')) {
            return true;
        }

        return false;
    }

    /**
     * Charge specified amount from the payment profile.
     *
     * @param  int  $customerId
     * @param  int  $paymentId
     * @param  float  $amount
     * @return string|bool
     */
    public function charge($customerId, $paymentId, float $amount)
    {
        $customer = new CustomerProfilePaymentType();
        $customer->setCustomerProfileId($customerId);

        $profile = new PaymentProfileType();
        $profile->setPaymentProfileId($paymentId);

        $customer->setPaymentProfile($profile);

        // Create a transaction
        $transaction = new TransactionRequestType();
        $transaction->setTransactionType('authCaptureTransaction');
        $transaction->setAmount($amount);
        $transaction->setProfile($customer);

        // Assemble the complete transaction request
        $request = new CreateTransactionRequest();

        $request->setMerchantAuthentication($this->getAuthentication());
        $request->setTransactionRequest($transaction);

        // Send request to API
        $controller = new CreateTransactionController($request);

        $response = $controller->executeWithApiResponse(ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == 'Ok')) {
            $transactionResponse = $response->getTransactionResponse();

            if ($transactionResponse != null && $transactionResponse->getMessages() != null) {
                return $transactionResponse->getTransId();
            }
        }

        return false;
    }

    /**
     * Create a new customer profile in the Authorize.Net.
     *
     * @param  \App\User  $user
     * @return \net\authorize\api\contract\v1\CustomerAddressType
     */
    public function getCustomerAddress(User $user)
    {
        $address = new CustomerAddressType();

        if ($user->first_name) {
            $address->setFirstName($user->first_name);
        }

        if ($user->last_name) {
            $address->setLastName($user->last_name);
        }

        if ($user->hasBillingAddress) {
            if ($user->billing_address) {
                $billto->setAddress($user->billing_address);
            }

            if ($user->billing_country) {
                $billto->setCountry($user->billing_country);
            }

            if ($user->billing_city) {
                $billto->setCity($user->billing_city);
            }

            if ($user->billing_state) {
                $billto->setState($user->billing_state);
            }

            if ($user->billing_postcode) {
                $billto->setZip($user->billing_postcode);
            }
        } else {
            if ($user->address) {
                $billto->setAddress($user->address);
            }

            if ($user->country) {
                $billto->setCountry($user->country);
            }

            if ($user->city) {
                $billto->setCity($user->city);
            }

            if ($user->state) {
                $billto->setState($user->state);
            }

            if ($user->postcode) {
                $billto->setZip($user->postcode);
            }
        }

        return $address;
    }
}
