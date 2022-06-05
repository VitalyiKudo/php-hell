<?php

declare(strict_types=1);

namespace App\Traits;
/*
use Square\Models\CreatePaymentRequest;
use Square\Models\Money;
use Square\SquareClient;
*/
use Square\SquareClient;
use Square\Models\Money;
use Square\Models\CreatePaymentRequest;
use Square\Environment;
use Square\Exceptions\ApiException;

use Dotenv\Dotenv;
use Ramsey\Uuid\Uuid;

trait PaymentSquareTrait
{
    public function paymentSquareTrait ($access_token, $total_price, $nonce, $orderId) {
/*
        $client = new SquareClient([
           'accessToken' => $access_token,
           'environment' => getenv('ENVIRONMENT')
       ]);
*/

$client = new SquareClient([
       #'accessToken' => getenv('SQUARE_ACCESS_TOKEN'),
       #'environment' => ENVIRONMENT::SANDBOX,
       'accessToken' => $access_token,
       'environment' => getenv('ENVIRONMENT'),

   ]);
#dd($client);
try {

    $apiResponse = $client->getLocationsApi()->listLocations();
#dd($apiResponse);
    if ($apiResponse->isSuccess()) {
        $result = $apiResponse->getResult();
        /*foreach ($result->getLocations() as $location) {
            printf(
                "%s: %s, %s, %s<p/>",
                $location->getId(),
                $location->getName(),
                $location->getAddress()->getAddressLine1(),
                $location->getAddress()->getLocality()
            );
        }*/

    } else {
        $errors = $apiResponse->getErrors();
        foreach ($errors as $error) {
            printf(
                "%s<br/> %s<br/> %s<p/>",
                $error->getCategory(),
                $error->getCode(),
                $error->getDetail()
            );
        }
    }

} catch (ApiException $e) {
    echo "ApiException occurred: <b/>";
    echo $e->getMessage() . "<p/>";
}
        $payments_api = $client->getPaymentsApi();
        #$payments_api = $square_client->getPaymentsApi();

// To learn more about splitting payments with additional recipients,
// see the Payments API documentation on our [developer site]
// (https://developer.squareup.com/docs/payments-api/overview).

        $money = new Money();
        /*
// Monetary amounts are specified in the smallest unit of the applicable currency.
// This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
        $money->setAmount(100);
// Set currency to the currency for the location
        $money->setCurrency($location_info->getCurrency());
        $money = new Money();
        */

        $money->setAmount((int)$total_price*100);
        // TO DO $result->location
        $money->setCurrency('USD');

#dd($money);
        $create_payment_request = new CreatePaymentRequest($nonce, uniqid('', true), $money);
        #$create_payment_request = new CreatePaymentRequest($nonce, Uuid::uuid4(), $money);
        #$create_payment_request->setOrderId((string)$orderId);
#dd($create_payment_request);
        #dd($payments_api->createPayment($create_payment_request));
        return  $payments_api->createPayment($create_payment_request);
        /*
            // If there was an error with the request we will
            // print them to the browser screen here
            if ($response->isError()) {
                //echo 'Api response has Errors';
                $errors = $response->getErrors();
                //echo '<ul>';
                foreach ($errors as $error) {
                    //echo '<li>❌ ' . $error->getDetail() . '</li>';
                    $cart_errors[] = $error->getDetail();
                }
                //echo '</ul>';
                //exit();

            }
            */
    }
}
