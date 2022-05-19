@extends('client.layouts.app')
@section('meta')
<title>JetOnset Support | Get In Touch Today!</title>
    <meta name="description" content="Are you a client who needs assistance with their flight or an operator wishing to join? Click here!">
@endsection

@section('content')

<div class="section header-page-image"></div>

<div class="section support-for-clients" id="contact">
    @if (session('status'))
        <div class="container">
            <div class="alert alert-success mb-5" role="alert">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <div class="container support-for-clients-title">
        <div class="row">
            <div class="col text-justify">
                <h2 class="mb-3">For Clients</h2>
                <p class="mb-0">Feel free to reach out to us for any questions and concerns you might have!</p>
                <p class="mb-0">We have agents that will help with om demand inquiries and the press.</p>
            </div>
        </div>
    </div>

    <form method="POST" class="mb-5" action="{{ route('client.support.client') }}">
        @csrf

        <div class="container support-for">
            <div class="row">
                <div class="col-md-7 support-text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientName">Your name</label>
                                <input id="clientName" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', (isset(Auth::user()->full_name)) ? Auth::user()->full_name : '') }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientEmail">Email</label>
                                <input id="clientEmail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', (isset(Auth::user()->email)) ? Auth::user()->email : '') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientPhone">Phone</label>
                                <input id="clientPhone" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number', (isset(Auth::user()->phone_number)) ? Auth::user()->phone_number : '') }}">

                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientCompany">Company</label>
                                <input id="clientCompany" type="text" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="company" value="{{ old('company') }}">

                                @if ($errors->has('company'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="clientMessage">Message</label>
                        <textarea id="clientMessage" type="text" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" placeholder="Hi, I'm interested in ...">{{ old('message') }}</textarea>

                        @if ($errors->has('message'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn d-block m-auto btn-lg">Send</button>
                </div>

                <div class="col-md-5 support-image-for-clients"></div>
            </div>
        </div>
    </form>
</div>

<div class="section support-for-operators">
    <div class="container support-for-operators-title">
        <div class="row">
            <div class="col text-justify">
                <h2 class="mb-3">For Operators</h2>
                <p class="mb-0">Don't let your fleet go to waste! Join our network and get access to new leads, new clients and new flights! Reach out today.</p>
            </div>
        </div>
    </div>

    <form method="POST" class="mb-5" action="{{ route('client.support.operator') }}">
        @csrf

        <div class="container support-for">
            <div class="row">
                <div class="col-md-7 support-text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="operatorName">Your name</label>
                                <input id="operatorName" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="operatorEmail">Email</label>
                                <input id="operatorEmail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="operatorPhone">Phone</label>
                                <input id="operatorPhone" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}">

                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="operatorCompany">Company</label>
                                <input id="operatorCompany" type="text" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="company" value="{{ old('company') }}">

                                @if ($errors->has('company'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="operatorMessage">Message</label>
                        <textarea id="operatorMessage" type="text" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" placeholder="Hi, I'm interested in ...">{{ old('message') }}</textarea>

                        @if ($errors->has('message'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn d-block m-auto">Send</button>
                </div>

                <div class="col-md-5 support-image-for-operators"></div>
            </div>
        </div>
    </form>
</div>

<div class="section questions" id="faqs">
    <div class="container" style="margin-top: 2rem;">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-3">Booking Questions</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseBookingQuestion1" role="button" aria-expanded="false" aria-controls="collapseBookingQuestion1">Does the price include taxes and fees?</a>
                        <div class="collapse" id="collapseBookingQuestion1">
                            <p class="mt-3 mb-0">The price includes only landing fees and airport fees. For taxes, you will pay these in addition to the amount of your quote.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseBookingQuestion2" role="button" aria-expanded="false" aria-controls="collapseBookingQuestion2">What if i need to cancel?</a>
                        <div class="collapse" id="collapseBookingQuestion2">
                            <p class="mt-3 mb-0">JetOnset offers you a flexible cancellation, allowing a full refund of your money into your JetOnset account for future use if you cancel within 48 hours before departure.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseBookingQuestion3" role="button" aria-expanded="false" aria-controls="collapseBookingQuestion3">Does JetOnset accept bitcoin?</a>
                        <div class="collapse" id="collapseBookingQuestion3">
                            <p class="mt-3 mb-0">JetOnset will soon accept Bitcoin, but note that it takes up to 6 hours for a confirmation mail. Select the BTC as your payment method, and upon confirmation, we will send you the detailed invoice.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseBookingQuestion4" role="button" aria-expanded="false" aria-controls="collapseBookingQuestion4">Does JetOnset accept wire transfers and ACH?</a>
                        <div class="collapse" id="collapseBookingQuestion4">
                            <p class="mt-3 mb-0">ACH and wire transfers are accepted at JetOnset, select the method of payment, and we will email you an invoice upon completion of the booking. It may not work for same-day travels, ACH takes three days, and wire transfer takes 48 hours to reflect in our accounts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 4rem;">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-3">About Your Private Jet Flight</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq1" role="button" aria-expanded="false" aria-controls="collapseFaq1">What JetOnset does to ensure the safety of my flight?</a>
                        <div class="collapse" id="collapseFaq1">
                            <p class="mt-3 mb-3">Safety is our key priority, and we have zero tolerance for errors. We try to identify and mitigate risk before it happens.</p>
                            <ul>
                                <li><p class="mb-0">We check the jet’s insurance policy and its safety history, including its financial reports and tax filings.</p></li>
                                <li><p class="mb-0">We audit the jet’s account and look for any issues that may cause alarm.</p></li>
                                <li><p class="mb-0">We ensure the crew is qualified and certified, and have experience in their work.</p></li>
                                <li><p class="mb-0">We double-check the PASS system and compare it against the FAA and ICAO databases.</p></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq2" role="button" aria-expanded="false" aria-controls="collapseFaq2">How early should i arrive?</a>
                        <div class="collapse" id="collapseFaq2">
                            <p class="mt-3 mb-0">We recommend to be at the airport at least 15 minutes before your departure. Feel free to communicate with us in case of any emergency events arise.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq3" role="button" aria-expanded="false" aria-controls="collapseFaq3">Can you bring firearms on a private jet flight or a hunting trip?</a>
                        <div class="collapse" id="collapseFaq3">
                            <p class="mt-3 mb-0">Yes. There are a few bits of rules and recommendations as well:</p>
                            <ul>
                                <li><p class="mb-0">You have to communicate ahead of time;</p></li>
                                <li><p class="mb-0">Lock away the firearm in its case. No loaded guns or free triggers in the cabin;</p></li>
                                <li><p class="mb-0">Unload firearms in their cases, and store ammunition separately;</p></li>
                                <li><p class="mb-0">Check your destination county for permission to carry weapons as well.</p></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section concierge">
    <div class="container">
        <div class="row">
            <div class="col-10 offset-1 col-lg-6 offset-lg-3">
                <div class="row align-items-center visit-card">
                    <div class="col-lg-5">
                        <img src="/images/consirge.webp" loading="lazy" class="" alt="...">
                    </div>
                    <div class="col-lg-7">
                        <p class="mb-0"><strong>Kylie Larson</strong></p>
                        <p class="mb-3">Concierge Service</p>
                        <a href="mailto:concierge@jetonset.com"><p class="mb-0 txt-color">concierge@jetonset.com</p></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
