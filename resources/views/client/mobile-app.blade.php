@extends('client.layouts.app')
@section('meta')
<title>JetOnset Mobile App Download</title>
    <meta name="description" content="Get connected to our chartered jets at record speed with the JetOnset mobile app!">
@endsection

@section('content')

<div class="section mobile-app-title">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="mb-3">JetOnset Mobile App Download</h2>
                <p class="mb-0">We understand the urgent needs and requests that pop-up, and every so often you just need to book a private jet on the fly! That's exactly why we have developed both Android and iOS apps that are the fastest way in the world to reserve a private jet on demand! Check out the app today using whichever system you'll be using it on via the links below!</p>
            </div>
        </div>
    </div>
</div>

<div class="section mobile-app-benefits">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h2 class="mb-3">App Benefits</h2>
                    <p class="mb-4">We understand the urgent needs and requests that pop-up, and every so often you just need to book a private jet on the fly! That's exactly why we have developed both Android and iOS apps that are the fastest way in the world to reserve a private jet on demand! Check out the app today using whichever system you'll be using it on via the links below!</p>
                    <p class="mb-0">While the app might not be beneficial to most people, for frequent flyers it can be a lifesaver. The app allows you the fastest path to your next jet flight, and it works anywhere in the world as long as you have an internet connection and some power left on your phone!</p>
                </div>
            </div>
        </div>
        <div class="container download-container">
            <div class="row">
                <div class="col-12 col-lg-auto ios">
                    <img src="/images/iOS-logo.webp" loading="lazy" class="download-img" alt="...">
                    <p class="download-text">Download Now for iOS</p>
                </div>
                <div class="col-12 col-lg-auto android">
                    <img src="/images/Android-logo.webp" loading="lazy" class="download-img" alt="...">
                    <p class="download-text">Download Now for Android</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section concierge">
    <div class="container">
        <div class="row">
            <div class="col-10 offset-1 col-lg-6 offset-lg-3">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <img src="/images/person.webp" loading="lazy" class="" alt="...">
                    </div>
                    <div class="col-lg-6">
                        <p class="mb-0"><strong>Kylie Larson</strong></p>
                        <p class="mb-3">Concierge Service</p>
                        <a href="mailto:concierge@jetonset.com"><p class="mb-0">concierge@jetonset.com</p></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection