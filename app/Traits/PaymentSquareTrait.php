<?php

declare(strict_types=1);

namespace App\Traits;

use Square\Models\CreatePaymentRequest;
use Square\Models\Money;
use Square\SquareClient;

trait PaymentSquareTrait
{
    public function paymentSquareTrait ($access_token, $total_price, $nonce, $orderId) {

        $client = new SquareClient([
           'accessToken' => $access_token,
           'environment' => getenv('ENVIRONMENT')
       ]);

        $payments_api = $client->getPaymentsApi();

        $money = new Money();
        $money->setAmount($total_price*100);
        $money->setCurrency('USD');
        $create_payment_request = new CreatePaymentRequest($nonce, uniqid('', true), $money);
        #$create_payment_request->setOrderId((string)$orderId);
#dd($create_payment_request);
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
