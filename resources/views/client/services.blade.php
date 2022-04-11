@extends('client.layouts.app')
@section('meta')
<title>JetOnset Services | Discover What We Offer</title>
    <meta name="description" content="Luxury travel and vacations to corporate retreats and medical tourism - JetOnset offers it all with our chartered jets!">
@endsection

@section('content')

<div class="section services-title"></div>

<div class="section services-list">
    <div class="container">
        <div class="row">
            <div class="col services-right">
                <h1 class="">JetOnset Services</h1>
                <!-- <p class="mb-0 title-p-text">While we offer the greatest fleet and pricing for private jets, it's important that you understand the unique aspects and details that are included in the JetOnset experience. You can also learn from unique opportunities and uses for private jets that you never knew were even an option! Here, we will expand upon in detail the common and uncommon uses JetOnset customers to enjoy on a regular basis!</p> -->
            </div>
        </div>
    </div>
    <div class="container services services-right">
        <div class="row ">
            <div class="col-md-6 services-text">

                <h5 class="services-h2">Luxury Travel, Luxury Vacations</h5>
                <p class="services-p color-white">You can’t experience luxury travel or luxury vacations by starting them off in economy class on a commercial airliner. With JetOnset, your luxurious getaways will get off on the right foot with a world-class experience on a private chartered jet. </p>
                <div class="row mt-5">
                    <div class="col-md-1 pr-md-0 img-align service-fancy-separator">
                        <img src="/images/line3.webp" loading="lazy" alt="line">
                    </div>
                    <div class="col-md-10 service-fancy-p">
                        <p>We have access to almost any jet size, shape, and class you can imagine. It doesn’t matter if you want to travel to a nearby island or halfway around the world - we have the jets for you! World-class!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 services-image luxury-travel-image"></div>
        </div>
    </div>
    <div class="container services services-fullwidth">
        <div class="row">
            <div class="col-md-6 services-image corporate-travel-image"></div>
            <div class="col-md-6 services-text">
                <h5 class="services-h2">Corporate Travel, Corporate Retreats</h5>
                <p class="services-p color-white">Treat your executives or clients like the valued stakeholders that they are with the use of private jets and chartered planes for your next shareholder meeting. Have a once-in-a-lifetime client potential or want to treat your executives to a special treat? </p>

                <div class="row mt-5">
                    <div class="col-md-1 pr-md-0 service-fancy-separator">
                        <img src="/images/line3.webp" loading="lazy" alt="line">
                    </div>
                    <div class="col-md-11 service-fancy-p">
                        <p>With JetOnset you can rest assured that nothing will surpass this revolutionary way of travel. Spontaneous new sales meetings or pre-arranged travel plans are no problem, and when your clients know how much you care about their experience, they will return the same treatment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container services services-right">
        <div class="row">
            <div class="col-md-6 services-text">
                <h5 class="services-h2">Private Cargo Transportation | Luxury Car Relocation</h5>
                <p class="services-p color-white">Do you want to move a priceless or prized possession? From multi-million dollar luxury custom cars to archeological artifacts and relics of art from the past - there is no safer way to relocate them than with a private chartered jet.</p>

                <div class="row mt-5">
                    <div class="col-md-1 pr-md-0 service-fancy-separator">
                        <img src="/images/line3.webp" loading="lazy" alt="line">
                    </div>
                    <div class="col-md-10 service-fancy-p">
                        <p> We have a fleet of jets varied enough to transport almost any object of any size.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 services-image private-transportation-image"></div>
        </div>
    </div>
    <div class="container services services-fullwidth">
        <div class="row">
            <div class="col-md-6 services-image medical-tourism-image"></div>
            <div class="col-md-6 services-text">
                <h5 class="services-h2">Medical Tourism | Private Jet Ambulance</h5>
                <p class="services-p color-white">With the rise of medical tourism as a better alternative for certain individuals in certain situations, JetOnset can maximize your comfort and experience on the way to or from your treatment!</p>

                <div class="row mt-5">
                    <div class="col-md-1 pr-md-0 service-fancy-separator">
                        <img src="/images/line3.webp" loading="lazy" alt="line">
                    </div>
                    <div class="col-md-11 service-fancy-p">
                        <p> We even have the capability in certain situations to effectively operate nearly as an ambulance with our fast service using our apps and technologies! Certain surgeries can be so expensive that you might end up saving money while you fly out to optimum luxury for the same procedure!</p>
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
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <img src="/images/consirge.webp" loading="lazy" class="" alt="...">
                    </div>
                    <div class="col-lg-6">
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
