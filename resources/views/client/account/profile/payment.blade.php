@extends('client.account.profile.layout')
@section('meta')
<title>Payment Method | JetOnset</title>
@endsection

@section('profile-title')
Payment
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="row cards-block">
            <div class="col-md-12 mb-4">
                <div class="form-group cards-list mb-2">
                    <p>Your payment cards</p>
                    <div class="row">
                        @foreach ($user->cards as $item)
                            <div class="col-auto text-center">
                                <a href="{{ route('client.profile.payment.show', $item->id) }}" class="d-flex plus-btn align-items-center justify-content-center bg-primary text-white border-primary text-decoration-none">
                                    Card
                                </a>

                                <small>•••• {{ $item->last_four }}</small>
                            </div>
                        @endforeach

                        <div class="col-auto">
                            <a href="{{ route('client.profile.payment.index') }}" class="d-flex plus-btn align-items-center">
                                <img src="/images/plus2.webp" loading="lazy" class="icon-img" alt="...">
                            </a>
                        </div>
                    </div>
                </div>
                
                <p class="mb-0">{{ isset($card) ? 'Choosen card details' : 'Add a new card' }}</p>
            </div>
        </div> 

        @if (! isset($card))
            <form method="POST" class="mb-5" action="{{ route('client.profile.payment.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="name">{{ __('Cardholder name') }}</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autocomplete="off">
                        
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="number">{{ __('Card number') }}</label>
                            <input id="number" type="text" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" value="{{ old('number') }}" maxlength="16" required autocomplete="off">
                        
                            @if ($errors->has('number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-lg-4 col-xl-3 col-6">
                        <div class="form-group">
                            <label for="expiration_month">Expiration date</label>
                            <div class="form-row align-items-center">
                                <div class="col-5">
                                    <input type="text" class="form-control{{ $errors->has('expiration_month') ? ' is-invalid' : '' }}" id="expiration_month1" name="expiration_month" value="{{ old('expiration_month') }}" required maxlength="2" autocomplete="off">
                                </div>
                                <div class="col-auto date-sep">
                                    <p class="mb-0">/</p>
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control{{ $errors->has('expiration_year') ? ' is-invalid' : '' }}" id="expiration_year1" name="expiration_year" value="{{ old('expiration_year') }}" required maxlength="2" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-xl-3 col-6">
                        <div class="form-group">
                            <label for="cvv">{{ __('Card CVV') }}</label>
                            <input id="cvv" type="password" class="form-control{{ $errors->has('cvv') ? ' is-invalid' : '' }}" name="cvv" value="{{ old('cvv') }}" required maxlength="4" autocomplete="off">

                            <button type="button" class="btn cvv-btn" data-toggle="popover" data-placement="right" data-content="Text about SVV?">?</button>
                        </div>
                    </div>

                    <div class="col-12">
                        @if ($errors->has('expiration_month'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('expiration_month') }}</strong>
                            </span>
                        @endif

                        @if ($errors->has('expiration_year'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('expiration_year') }}</strong>
                            </span>
                        @endif

                        @if ($errors->has('cvv'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('cvv') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn mt-3">
                        {{ __('Add card') }}
                    </button>
                </div>
            </form>
        @else
            <form method="POST" action="{{ route('client.profile.payment.destroy', $card->id) }}">
                @csrf
                @method('DELETE')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label>{{ __('Card number') }}</label>
                            <input type="text" class="form-control" name="card_number" value="•••• •••• •••• {{ $card->last_four }}" autocomplete="off" disabled>

                            @if ($errors->has('number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-xl-3 col-5">
                        <div class="form-group mb-4">
                            <label>Expiration date</label>
                            <div class="form-row align-items-center">
                                <div class="col-5">
                                    <input type="text" class="form-control" value="{{ $card->expiration_month }}" disabled>
                                </div>
                                <div class="col-auto date-sep">
                                    <p class="mb-0">/</p>
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" value="{{ $card->expiration_year }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn dlt-btn mt-3">
                    {{ __('Delete card') }}
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
