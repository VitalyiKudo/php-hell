<?php

namespace App\Providers\Helpdeskeddy;

use Auth;
use App\Models\User;
use GuzzleHttp\Client as HttpClient;

class Helpdeskeddy
{
    /**
     * The HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Create a new Helpdeskeddy client instance.
     *
     * @param  \GuzzleHttp\Client  $http
     * @return void
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a new ticket.
     *
     * @param  array  $body
     * @return bool
     */
    public function createTicket($body = [])
    {
        // if (Auth::guard('client')->check()) {
        //     $user = Auth::guard('client')->user();

        //     $body['user_id'] = $user->id;

        //     if (empty($body['user_email'])) {
        //         $body['user_email'] = $user->email;
        //     }
        // }

        $response = $this->http->post('tickets', [
            'form_params' => $body,
        ]);

        $body = $response->getBody()->getContents();
        $json = json_decode($body);

        return ! is_null($json) && isset($json->data) && isset($json->data->id);
    }
}
