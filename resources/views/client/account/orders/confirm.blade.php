@extends('client.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="mb-4">Flight data</h2>

            Name ..
        </div>
        
        @if (session('status'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        </div>
        @endif
        
        
        
        <?php
            $messages = Session::get('messages');
            //echo "<pre>";
            //print_r($messages);
           // echo "</pre>";
        ?>
        @if ($messages)
            <div class="alert alert-danger">
              <ul>
                  @foreach ($messages->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
              </ul>
            </div><br />
        @endif
        
        

        <div class="col-md-8">
            <form method="POST" action="{{ route('client.orders.checkout') }}">
                @csrf

                <h2 class="mb-4">Booking your flight</h2>

                Payment schedule
                10% payment    Full payment


                Summary ..
                
                <hr>
                
                <p>{{ $search_type }} | {{ $pricing->departure }} - {{ $pricing->arrival }} | {{ number_format($price, 2, '.', ' ') }}</p>

                <div class="row my-5">
                    <div class="col-md-6">
                        <input type="hidden" name="search_result_id" value="{{ $search_id }}">
                        <input type="hidden" name="search_result_type" value="{{ $search_type }}">
                        <input type="hidden" name="price" value="{{ number_format($price, 2, '.', ' ') }}">
                        <input type="hidden" name="type" value="{{ $search_type }}">
                        <div class="form-group">
                            <label for="billing_address">Billing Address</label>
                            <input type="text" name="billing_address" value="{{ old('billing_address') }}" class="form-control" id="billing_address">
                        </div>
                        <div class="form-group">
                            <label for="billing_address_secondary">Billing Address Secondary</label>
                            <input type="text" name="billing_address_secondary" value="{{ old('billing_address_secondary') }}" class="form-control" id="billing_address_secondary">
                        </div>
                        <div class="form-group">
                            <label for="billing_country">Billing Country</label>
                            <input type="text" name="billing_country" value="{{ old('billing_country') }}" class="form-control" id="billing_country">
                        </div>
                        <div class="form-group">
                            <label for="billing_city">Billing City</label>
                            <input type="text" name="billing_city" value="{{ old('billing_city') }}" class="form-control" id="billing_city">
                        </div>
                        <div class="form-group">
                            <label for="billing_province">Billing Province</label>
                            <input type="text" name="billing_province" value="{{ old('billing_province') }}" class="form-control" id="billing_province">
                        </div>
                        <div class="form-group">
                            <label for="billing_postcode">Billing Postcode</label>
                            <input type="text" name="billing_postcode" value="{{ old('billing_postcode') }}" class="form-control" id="billing_postcode">
                        </div>

                        <div class="form-group">
                            <label for="comment">Billing Comment</label>
                            <textarea type="text" name="comment" class="form-control" id="comment">{{ old('comment') }}</textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_accepted" value="on" class="form-check-input" id="is_accepted" {{ old('is_accepted') == 'on' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_accepted">I accept</label>
                        </div>
                        <button class="btn btn-primary">Payment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

