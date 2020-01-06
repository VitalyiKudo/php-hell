@extends('client.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="mb-4">Flight data</h2>

            Name ..
        </div>

        <div class="col-md-8">
            <form method="POST" action="{{ route('client.orders.payment', $order->id) }}">
                @csrf

                <h2 class="mb-4">Booking your flight</h2>

                Payment schedule
                10% payment    Full payment


                Summary ..

                <div class="row my-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="custom-select{{ $errors->has('card_id') ? ' is-invalid' : '' }}" name="card_id">
                                @foreach ($cards as $card)
                                    <option value="{{ $card->id }}">•••• {{ $card->last_four }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('card_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('card_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button class="btn btn-primary">Payment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

