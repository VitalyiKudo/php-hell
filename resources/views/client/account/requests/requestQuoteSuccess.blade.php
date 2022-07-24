@extends('client.layouts.app')
@section('meta')
    <title>Requests | JetOnset</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
@endsection

@section('book_page', 'book-page-nav')

@section('content')
    <div class="container header-page-image header-page-image-bg"></div>
    <div class="section main-search-page header-page-image-request-quote">
        <div class="container">
            <div class="row">

                <div class="offset-md-1 col-md-8">

                    @if($lastSearchResults)
                    <nav aria-label="breadcrumb" class="row search-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><span class="search-title">Last searches:</span></li>
                            @foreach ($lastSearchResults as $lastSearch)
                                <li class="breadcrumb-item">
                                    <a href="#" data-from="{{ $lastSearch->departureCity->name }}" data-to="{{ $lastSearch->arrivalCity->name }}">
                                        <span class="search-item-first">{{ $lastSearch->departureCity->name }}</span>
                                        <span class="search-item-second">{{ $lastSearch->arrivalCity->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid request-search-page-success">

        <div class="row">

            <div class="col-xl-12 col-lg-12">


                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-inner-body pl-4">
                            <div class="custom-flight-page">
                                <img src="{{ asset('images/list-icon.svg') }}" alt="list-icon" class="rounded mx-auto d-block"/>
                                <div>Your request has been send successfully!</div>
                                <p>Request number: <span>#{{ $params['reqest_number'] }}</span></p>
                                <a href="{{ route('client.profile.account.index') }}">View in Cabinet</a>
                            </div>



                        </div>

                    </div>
                </div>

                <div class="pb-5"></div>

            </div>
        </div>
    </div>

@endsection
