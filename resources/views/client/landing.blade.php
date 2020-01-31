@extends('client.layouts.app')
@section('meta')
<title>Private Jet Charter | JetOnset</title>
    <meta name="description" content="JetOnset provides world class private jet charters that will change the way you fly forever.">
@endsection

@section('content')
    <!--<search-form></search-form>-->

<div class="section main-search">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mb-3">Private Jet Charter: Fly Different Today</h1>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Departure Airport" aria-describedby="departure-airport">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="departure-airport"><img src="/images/departure-icon.png" class="icon-img" alt="..."></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Arrival Airport" aria-describedby="arrival-airport">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="arrival-airport"><img src="/images/arrival-icon.png" class="icon-img" alt="..."></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Date & Time" aria-describedby="date-time">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="date-time"><img src="/images/date-icon.png" class="icon-img" alt="..."></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Passengers" aria-describedby="passengers">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="passengers"><img src="/images/passengers-icon.png" class="icon-img" alt="..."></span>
                    </div>
                </div>
            </div>
            <div class="col-4 offset-4 col-sm-2 offset-sm-5 col-lg-1 offset-lg-0 mb-3">
                <button type="button" class="plus-btn">
                    <img src="/images/plus.png" class="icon-img" alt="...">
                </button> 
            </div>
            <div class="col-lg-2 form-container-1">
                <button type="button" class="btn">Search</button>
            </div>
            <div class="col-lg-12">
                <a href="#how-it-works"><img src="/images/scroll.png" class="scroll-button" alt="..."></a>
            </div>
        </div>
    </div>
</div>

<div class="section main-works" id="how-it-works">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-3">How It Works</h2>
                <p class="font-weight-bold mb-0">It’s simple.</p>
                <p class="mb-0">You choose where you want to go, when you want to go, and where you are coming from to get started. Next, we will show you every option available with an accurate price quote. Finally, you choose the private jet that fits your needs. It’s that simple.</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-search.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Search for your flight</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.png" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-choose.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Choose a flight that fits you</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.png" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-book.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Book your flight</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.png" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-wait.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Wait for a confirmation</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.png" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card last-card">
                    <img src="/images/works-enjoy.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Enjoy your flight</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section main-services">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="mb-3">Services</h2>
            </div>
        </div>
    </div>
    <div class="container services services-right mt-0">
        <div class="row">
            <div class="col-md-6 services-text">
                <h2 class="services-h2 color-white">Luxury Travel | Luxury Vacations</h2>
                <p class="services-p color-white">You can’t experience luxury travel or luxury vacations by starting them off in economy class on a commercial airliner. With JetOnset, your luxurious getaways will get off on the right foot with a world-class experience on a private chartered jet. We have access to almost any jet size, shape, and class you can imagine. It doesn’t matter if you want to travel to a nearby island or halfway around the world - we have the jets for you! World-class!</p>
            </div>
            <div class="col-md-6 services-image luxury-travel-image"></div>
        </div>
    </div>
    <div class="container services services-fullwidth">
        <div class="row">
            <div class="col-md-6 services-image corporate-travel-image"></div>
            <div class="col-md-6 services-text">
                <h2 class="services-h2 color-white">Corporate Travel | Corporate Retreats</h2>
                <p class="services-p color-white">Treat your executives or clients like the valued stakeholders that they are with the use of private jets and chartered planes for your next shareholder meeting. Have a once-in-a-lifetime client potential or want to treat your executives to a special treat? With JetOnset you can rest assured that nothing will surpass this revolutionary way of travel. Spontaneous new sales meetings or pre-arranged travel plans are no problem, and when your clients know how much you care about their experience, they will return the same treatment.</p>
            </div>
        </div>
    </div>
    <div class="container container-bottom">
        <div class="row">
            <div class="col-auto">
                <a href="/services" class="mb-0">See more</a>
            </div>
        </div>
    </div>
</div>

<div class="section main-get-mobile">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h2 class="mb-3">Get Mobile</h2>
                <p class="mb-0">Are you a frequent flyer and need the ultimate speed and flexibility in private jet travel? Try our Mobile App and get to where you need to go, even faster!</p>
            </div>
        </div>
    </div>
    <div class="container download-container">
        <div class="row">
            <div class="col-12 col-md-auto ios">
                <img src="/images/iOS-logo.png" class="download-img" alt="...">
                <p class="download-text">Download Now for iOS</p>
            </div>
            <div class="col-12 col-md-auto android">
                <img src="/images/Android-logo.png" class="download-img" alt="...">
                <p class="download-text">Download Now for Android</p>
            </div>
        </div>
    </div>
</div>

<div class="section main-about-us">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-3">About Us</h2>
            </div>
            <div class="col-md-6">
                <p>We are a group of people who wanted to apply the social and technological revolution found in cars yesterday, to the private jets of today and tomorrow.</p>
                <p>We have started on our mission: To use crowdsourcing technology to revolutionize the way we think of private jets. We realize this is only the beginning, and we are helping to push the private jet industry into the hands of the few into the hands of many.</p>
            </div>
            <div class="col-md-6">
                <p>We have developed a proprietary system that allows you to skip middlemen and legal kickback costs and directly source your own private jet travel, regardless of the purpose or the destination.</p>
                <p>We have the ability in real-time to show you every plane, from the small HondaJet to the world renowned Boeing 737 that you can choose to fly to your destination in class.</p>
            </div>
            <div class="col-md-12">
                <a href="{{ url('about') }}" class="about-us-p-text">Learn more about JetOnset Co.</a>
            </div>
        </div>
    </div>
</div>

<div class="section testimonials testimonials-landing">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div id="testimonialsCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-interval="4000">
                            <div class="container">
                                <div class="col-12">
                                    <img src="/images/testimonials-top.png" class="testimonials-img" alt="...">
                                </div>
                                <div class="col-sm-10 offset-sm-1 col-12">
                                    <p class="testimonials-text mb-0">I’ve always dreaded the airports, especially for work. You guys have actually made this nightmare a much easier process for me to deal with.</p>
                                </div>
                                <div class="col-12 mb-5">
                                    <img src="/images/testimonials-bottom.png" class="testimonials-img float-right" alt="...">
                                </div>
                                <div class="col-10 offset-1">
                                    <div class="media">
                                        <img src="/images/slider/frank.png" class="testimonials-img align-self-center mr-2" alt="...">
                                        <div class="media-body mt-2">
                                            <p class="testimonials-person mb-0">Frank D.</p>
                                            <p class="testimonials-person mb-0">JetOnset Client</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-interval="4000">
                            <div class="container">
                                <div class="col-12">
                                    <img src="/images/testimonials-top.png" class="testimonials-img" alt="...">
                                </div>
                                <div class="col-sm-10 offset-sm-1 col-12">
                                    <p class="testimonials-text mb-0">My anxiety has always impacted my work. I have to frequently fly and this service has profoundly improved my “mental preparedness” for my work.</p>
                                </div>
                                <div class="col-12 mb-5">
                                    <img src="/images/testimonials-bottom.png" class="testimonials-img float-right" alt="...">
                                </div>
                                <div class="col-10 offset-1">
                                    <div class="media">
                                        <img src="/images/slider/serg.png" class="testimonials-img align-self-center mr-2" alt="...">
                                        <div class="media-body mt-10">
                                            <p class="testimonials-person mb-0">Sergio W.</p>
                                            <p class="testimonials-person mb-0">JetOnset Client</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-interval="4000">
                            <div class="container">
                                <div class="col-12">
                                    <img src="/images/testimonials-top.png" class="testimonials-img" alt="...">
                                </div>
                                <div class="col-sm-10 offset-sm-1 col-12">
                                    <p class="testimonials-text mb-0">My company has tried them out and saved a small fortune using this service. Same planes, half the price!</p>
                                </div>
                                <div class="col-12 mb-5">
                                    <img src="/images/testimonials-bottom.png" class="testimonials-img float-right" alt="...">
                                </div>
                                <div class="col-10 offset-1">
                                    <div class="media">
                                        <img src="/images/slider/aleksander.png" class="testimonials-img align-self-center mr-2" alt="...">
                                        <div class="media-body mt-10">
                                            <p class="testimonials-person mb-0">Alexander</p>
                                            <p class="testimonials-person mb-0">JetOnset Client</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-interval="4000">
                            <div class="container">
                                <div class="col-12">
                                    <img src="/images/testimonials-top.png" class="testimonials-img" alt="...">
                                </div>
                                <div class="col-sm-10 offset-sm-1 col-12">
                                    <p class="testimonials-text mb-0">Our company has private jets of their own, but some meetings are too sensitive for the public, and this service allows us to fly anywhere without rumors hurting the stock price.</p>
                                </div>
                                <div class="col-12 mb-5">
                                    <img src="/images/testimonials-bottom.png" class="testimonials-img float-right" alt="...">
                                </div>
                                <div class="col-10 offset-1">
                                    <div class="media">
                                        <img src="/images/slider/bradly.png" class="testimonials-img align-self-center mr-2" alt="...">
                                        <div class="media-body mt-10">
                                            <p class="testimonials-person mb-0">Bradly</p>
                                            <p class="testimonials-person mb-0">JetOnset Client</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-interval="4000">
                            <div class="container">
                                <div class="col-12">
                                    <img src="/images/testimonials-top.png" class="testimonials-img" alt="...">
                                </div>
                                <div class="col-sm-10 offset-sm-1 col-12">
                                    <p class="testimonials-text mb-0">My wife and I planned an extravagant wedding and honeymoon, but this was a surprise for her. Let’s just say it was worth every penny.</p>
                                </div>
                                <div class="col-12 mb-5">
                                    <img src="/images/testimonials-bottom.png" class="testimonials-img float-right" alt="...">
                                </div>
                                <div class="col-10 offset-1">
                                    <div class="media">
                                        <img src="/images/person.png" class="testimonials-img align-self-center mr-2" alt="...">
                                        <div class="media-body mt-10">
                                            <p class="testimonials-person mb-0">Henry S.</p>
                                            <p class="testimonials-person mb-0">JetOnset Client</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="section questions">
    <div class="container" style="margin-top: 2rem;">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-3">Frequent "Flyer" Questions</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq1" role="button" aria-expanded="false" aria-controls="collapseFaq1">What is Private Jet Charter?</a>
                        <div class="collapse" id="collapseFaq1">
                            <p class="mt-3 mb-3">JetOnset is the first platform in the world to allow you to comfortably fly on a private jet without having to own one. You can book on the 1700 plus private jets in the shortest time possible. Select from the four categories outlined; light jets, mid-size jets, long-range (heavy jets), and short-range turboprops for your appropriate fit. We guarantee you the best fit with the lowest prices on booking, for each jet category. Once you have your best jet choice, confirm your booking by paying either by Bitcoin, Credit card, Etherium, or wired transfer. Your flight is approved, and you can go ahead and start planning for your travel.</p>
                            <p class="mb-0"><strong>We offer you three convenient options:</strong></p>
                            <p class="mb-0"><strong>Door to Door</strong> - You are picked up from your doorstep and dropped at the doorstep of your destination.</p>
                            <p class="mb-0"><strong>Airport to Airport</strong> - From your departure airport to your arrival airport, everything is personally managed.</p>
                            <p class="mb-0"><strong>Flight Auctions</strong> - If your schedule is flexible; there are discounted prices for sale available for you.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq2" role="button" aria-expanded="false" aria-controls="collapseFaq2">How Much Does Private Charter Jet Cost?</a>
                        <div class="collapse" id="collapseFaq2">
                            <p class="mt-3 mb-0">JetOnset looks into its over 1700 available jets on the dates you are placing your reservation, and we ensure you get the lowest price possible. If you find another jet flight for less than we offer you, we will match the price and give you a 5% discount, if it is the same jet type, and the same travel route at the same time and date as yours.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq3" role="button" aria-expanded="false" aria-controls="collapseFaq3">Where To Charter A Private Jet?</a>
                        <div class="collapse" id="collapseFaq3">
                            <p class="mt-3 mb-0">JetOnset stays with you every step of the way and does not need any membership commitments. Also, with JetOnset, you only pay for your airtime, no more and no less. You are relaxing when the jet engine begins to when it stops.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq4" role="button" aria-expanded="false" aria-controls="collapseFaq4">Why Charter A Private Jet?</a>
                        <div class="collapse" id="collapseFaq4">
                            <p class="mt-3 mb-0">There are many reasons people and organizations charter private jets. It could be a romantic getaway for a grand honeymoon. It could also be a corporate retreat to reward your executives and employees. Some companies own their own planes and use these to avoid creating rumors as they visit their manufacturing facility unannounced.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq5" role="button" aria-expanded="false" aria-controls="collapseFaq5">How Long To Charter A Private Jet?</a>
                        <div class="collapse" id="collapseFaq5">
                            <p class="mt-3 mb-0">JetOnset operates around the clock, and booking two hours before departure is okay, but maybe affected by positions that may arise. Booking in advance is advised.</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq6" role="button" aria-expanded="false" aria-controls="collapseFaq6">Can I Charter A Private Jet?</a>
                        <div class="collapse" id="collapseFaq6">
                            <p class="mt-3 mb-0">As long as you aren’t on a No-Fly List and have the funds available to pay for the service, you absolutely can!</p>
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
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <img src="/images/person.png" class="" alt="...">
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
