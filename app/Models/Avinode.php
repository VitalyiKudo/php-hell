<?php


namespace App\Models;
use GuzzleHttp\Client;
use Carbon\Carbon;

class Avinode
{

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function all()
    {
       // $current_date = Carbon::createFromFormat('Y-m-d H:i:s.u', Carbon::now())->toIso8601String();

        $params = [
            array(
                'headers'=>array(
                    array( 'X-Avinode-ApiToken' => '01033232-12b5-41e8-b5f4-a58916179351'),
                    array('Content-Type' => 'application/json'),
                    array('X-Avinode-SentTimestamp' => "2020-01-29T22:49:47.000Z"),
                    array('Authorization' => 'Bearer eyJraWQiOiIxNkVBQkQ5RS1BRjYyLTQ4NTEtODk5Qi1BM0UwMThGRjYxNDciLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJzdWIiOiI1NzVFNjQ4MS0zRTQ0LTRGNUItQkMzOC1BMUQ0NzNERUQ2RjIiLCJhdmlkb21haW4iOiIuYXZpbm9kZS5jb20iLCJhdml0ZW5hbnQiOjExOTk2LCJpc3MiOiJhdmlub2RlIiwiYXZpdHlwZSI6MTYsImF2aW5vbmNlIjoiZDQyMTE1YmMtOGFlYy00NzYwLWJlOGQtOWY5N2JmZmQ3NmI3In0.AJx5gpabrzPkjQS7guCacwQjcfEekVniLbjJYDuh6yIaLmEjBnvhTCoJEqLueJ3y8GDcH9PDZ_n0AZE89VCITlI0LKqj3PRbq7i476UOqvJm3NMoOsRd-WJ3UG7rW0NoLQpVMulwlofEjWtcGp77_MNuwPB-ShpNimbO7g1HlncdSyIcY47MiV4v6lRNF7jnN3z8kQyLU9-VZgag7i83uhzXq01qG6_UR-9CjGmJ1ritAjV2asDs1THY3oL8QQ5Nu7M9X9YOig_f1RdtLXhKMGBjyIW6FQbY_7-Z5q6pQ3fe4S5fGSM8lGhxSCNBk0lm3xqke-TTsoSONnuNUHMgSA'),
                    ),
                'form_params' =>
                    array (
                        'segments' =>
                            array (
                                0 =>
                                    array (
                                        'startAirport' =>
                                            array (
                                                'icao' => 'EGGW',
                                            ),
                                        'endAirport' =>
                                            array (
                                                'icao' => 'KTEB',
                                            ),
                                        'dateTime' =>
                                            array (
                                                'date' => '2020-02-10',
                                                'time' => '11:00',
                                                'departure' => true,
                                                'local' => false,
                                            ),
                                        'paxCount' => '7',
                                    ),
                                1 =>
                                    array (
                                        'startAirport' =>
                                            array (
                                                'icao' => 'KTEB',
                                            ),
                                        'endAirport' =>
                                            array (
                                                'icao' => 'EGGW',
                                            ),
                                        'dateTime' =>
                                            array (
                                                'date' => '2020-02-15',
                                                'time' => '22:00',
                                                'departure' => true,
                                                'local' => false,
                                            ),
                                        'paxCount' => '7',
                                    ),
                            ),

                        )
                    )
                ];


        return $this->endpointRequest('https://sandbox.avinode.com/api/searches', $params);
    }

    public function findById($id)
    {
        return $this->endpointRequest('/dummy/post/'.$id);
    }

    public function endpointRequest($url, $params)
    {
        try {
            $response = $this->client->request('POST', $url,$params);

        } catch (\Exception $e) {
            return dd($e->getMessage());
        }

        return $this->response_handler($response->getBody()->getContents());
    }

    public function response_handler($response)
    {

        if ($response) {
            return json_decode($response);
        }

        return [];
    }

}
