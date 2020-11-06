@extends('client.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="mb-4">Flight data</h2>

            Name ..
        </div>
        

        <div class="col-md-8">
            <form method="POST" action="{{ route('client.orders.checkout') }}">

                <h2 class="mb-4">Booking your flight</h2>

                Payment schedule
                10% payment    Full payment


                Summary ..
                
                <hr>
                
                <p>{{ $order->type }} | {{ $search->start_airport_name }} - {{ $search->end_airport_name }} | {{ number_format($order->price, 2, '.', ' ') }}</p>

                <div class="row my-5">
                    <div class="col-md-6">
                        
                        
                        
                        
                        
                        <table class="table">
                            <tr>
                                <td>Billing Address</td>
                                <td>{{ $order->billing_address }}</td>
                            </tr>
                            <tr>
                                <td>Billing Address Secondary</td>
                                <td>{{ $order->billing_address_secondary }}</td>
                            </tr>
                            <tr>
                                <td>Billing Country</td>
                                <td>{{ $order->billing_country }}</td>
                            </tr>
                            <tr>
                                <td>Billing City</td>
                                <td>{{ $order->billing_city }}</td>
                            </tr>
                            <tr>
                                <td>Billing Province</td>
                                <td>{{ $order->billing_province }}</td>
                            </tr>
                            <tr>
                                <td>Billing Postcode</td>
                                <td>{{ $order->billing_postcode }}</td>
                            </tr>
                            <tr>
                                
                                <td>Billing Comment</td>
                                <td>{{ $order->comment }}</td>
                            </tr>
                        </table>
                        
                        
                        <input type="hidden" name="type" value="{{ $order->type }}">
                        <button class="btn btn-primary">Payment with Square</button>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

