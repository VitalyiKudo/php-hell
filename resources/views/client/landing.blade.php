@extends('client.layouts.app')
@section('meta')
<title>Private Jet Charter | JetOnset</title>
    <meta name="description" content="JetOnset provides world class private jet charters that will change the way you fly forever.">
@endsection

@section('content')
{{--    <search-form></search-form>--}}

<div class="section main-search">
    <div class="container">
        <form action="{{ route('flight.search') }}" method="POST">
            <div class="row form-body">

                <div class="col-lg-10">
                    <h4 class="mb-3 mt-4">Fly different today: Search your private jet</h4>
                </div>
                <div class="mb-3 mt-2 ml-3" style="width:23% !important">
                    <div class="input-group input-style-3">
                        <input type="text"
                               class="form-control from"
                               placeholder="Departure Airport"
                               aria-describedby="departure-airport"
                               name="startPoint"
                        >
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="departure-airport"><img src="/images/departure-icon.png" class="icon-img" alt="..."></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-2 pl-0 bd" style="width: 23% !important">
                    <div class="input-group input-style-2">
                        <input type="text"
                               class="form-control to"
                               placeholder="Arrival Airport"
                               aria-describedby="arrival-airport"
                               name="endPoint"
                        >
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="arrival-airport"><img src="/images/arrival-icon.png" class="icon-img" alt="..."></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-2 ml-3" style="width: 20% !important">
                    <div class="input-group input-style">
                        <input type="text" class="form-control " name="departure">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="date-time"><img src="/images/date-icon.png" class="icon-img" alt="..."></span>
                        </div>  
                    </div>

                </div>
                <div class="mb-3 mt-2 pl-0 ml-3" style="width:12% !important">
                    <div class="input-group input-style">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="passengers" name="passengers" ><img src="/images/passengers-icon.png" class="icon-img" alt="..."></span>
                        </div>
                        <input type="number" class="form-control" placeholder="Passengers" aria-describedby="passengers" name="passengers">
                        
                    </div>
                </div>
    {{--        <div class="col-4 offset-4 col-sm-2 offset-sm-5 col-lg-1 offset-lg-0 mb-3">--}}
    {{--             <button type="button" class="plus-btn">--}}
    {{--                 <img src="/images/plus.png" class="icon-img" alt="...">--}}
    {{--              </button>--}}
    {{--        </div>--}}
                <div class="form-container-1 mt-2 ml-3" style="width:12% !important">
                    <button type="submit" class="btn">Search</button>
                </div>
                <div class="col-lg-12 mb-5">
                    <a href="#how-it-works">
                    <img src="/images/mouse.png" class="scroll-button scroll-mouse2" alt="...">
                        <img src="/images/scroll.png" class="scroll-button" alt="...">
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
{{--<flight></flight>--}}
<div class="section main-works" id="how-it-works">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-3">How It Works</h2>
                <p class="font-weight-bold mb-3">It’s simple.</p>
                <p class="mb-0">You choose where you want to go, when you want to go, and where you are coming from to get started. Next, we will show you every option available with an accurate price quote. Finally, you choose the private jet that fits your needs. It’s that simple.</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-search.png" class="card-img-top" alt="...">
{{--                    <div class="card-body">--}}
{{--                        <p class="card-text">Search for your flight</p>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.png" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-choose.png" class="card-img-top" alt="...">
{{--                    <div class="card-body">--}}
{{--                        <p class="card-text">Choose a flight that fits you</p>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.png" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-book.png" class="card-img-top" alt="...">
{{--                    <div class="card-body">--}}
{{--                        <p class="card-text">Book your flight</p>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.png" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-wait.png" class="card-img-top" alt="...">
{{--                    <div class="card-body">--}}
{{--                        <p class="card-text">Wait for a confirmation</p>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="col-lg-1">
                <img src="/images/brown-devider.png"  alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card last-card">
                    <img src="/images/works-enjoy.png" class="card-img-top" alt="...">
{{--                    <div class="card-body">--}}
{{--                        <p class="card-text">Enjoy your flight</p>--}}
{{--                    </div>--}}
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

                <h5 class="services-h2 ">Luxury Travel, Luxury Vacations</h5>
                <p class="services-p">You can’t experience luxury travel or luxury vacations by starting them off in economy class on a commercial airliner. With JetOnset, your luxurious getaways will get off on the right foot with a world-class experience on a private chartered jet. </p>
                <div class="row mt-5">
                    <div class="col-md-1 pr-md-0">
                        <img src="/images/line.png" alt="line">
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
                <h2 class="services-h2">Corporate Travel, Corporate Retreats</h2>
                <p class="services-p color-white">Treat your executives or clients like the valued stakeholders that they are with the use of private jets and chartered planes for your next shareholder meeting. Have a once-in-a-lifetime client potential or want to treat your executives to a special treat? </p>

                <div class="row mt-5">
                    <div class="col-md-1 pr-md-0">
                        <img src="/images/line2.png" alt="line">
                    </div>
                    <div class="col-md-11 service-fancy-p">
                        <p>With JetOnset you can rest assured that nothing will surpass this revolutionary way of travel. Spontaneous new sales meetings or pre-arranged travel plans are no problem, and when your clients know how much you care about their experience, they will return the same treatment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container container-bottom">
        <div class="row">
            <div class="col-auto">
                <a href="/services" class="mb-0 see-more">See more</a>
            </div>
        </div>
    </div>
</div>

<div class="section main-get-mobile">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h2 class="mb-3">Get Mobile</h2>
                <p><strong>All Private Jets in your pocket</strong></p>
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
                <p><strong>We are a group of people</strong> who wanted to apply the social and technological revolution found in cars yesterday, to the private jets of today and tomorrow.</p>
                <p><strong>We have started on our mission:</strong> To use crowdsourcing technology to revolutionize the way we think of private jets. We realize this is only the beginning, and we are helping to push the private jet industry into the hands of the few into the hands of many.</p>
            </div>
            <div class="col-md-6">
                <p><strong>We have developed a proprietary system</strong> that allows you to skip middlemen and legal kickback costs and directly source your own private jet travel, regardless of the purpose or the destination.</p>
                <p>We have the ability in <strong> real-time </strong> to show you every plane, from the small <strong> HondaJet </strong> to the world renowned <strong> Boeing 737 </strong> that you can choose to fly to your destination in class.</p>
            </div>

            <div class="col-md-12 mt-5">

                <div class="offset-5 col-md-4 ">
                    <a href="{{ url('about') }}" class="learn-more">More about JetOnset Co.</a>
                </div>

            </div>


        </div>
    </div>
</div>

<div class="section testimonials testimonials-landing">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner">
                        <div class="carousel-item active" >
                            <div class="col-sm-10 offset-sm-1 col-12 text-bg">
                                <div class="col-md-12">
                                    <div class="col-md-2 img-pos">
                                        <img src="/images/slider/frank.png" class="testimonials-img align-self-center mr-2" alt="...">
                                    </div>
                                    <div class="col-md-10 text-pos">
                                        <h6>Frank D.</h6>
                                        <p> I’ve always dreaded the airports, especially for work. You guys have actually made this nightmare a much easier process for me to deal with </p>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="carousel-item" >
                            <div class="col-sm-10 offset-sm-1 col-12 text-bg">
                                <div class="col-md-12">
                                    <div class="col-md-2 img-pos">
                                        <img src="/images/slider/serg.png" class="testimonials-img align-self-center mr-2" alt="...">
                                    </div>
                                    <div class="col-md-10 text-pos">
                                        <h6>Sergio W.</h6>
                                        <p> My anxiety has always impacted my work. I have to frequently fly and this service has profoundly improved my “mental preparedness” for my work.</p>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="carousel-item" >
                            <div class="col-sm-10 offset-sm-1 col-12 text-bg">
                                <div class="col-md-12">
                                    <div class="col-md-2 img-pos">
                                        <img src="/images/slider/aleksander.png" class="testimonials-img align-self-center mr-2" alt="...">
                                    </div>
                                    <div class="col-md-10 text-pos">
                                        <h6>Alexander</h6>
                                        <p>My company has tried them out and saved a small fortune using this service. Same planes, half the price! </p>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="carousel-item" >
                            <div class="col-sm-10 offset-sm-1 col-12 text-bg">
                                <div class="col-md-12">
                                    <div class="col-md-2 img-pos">
                                        <img src="/images/slider/bradly.png" class="testimonials-img align-self-center mr-2" alt="...">
                                    </div>
                                    <div class="col-md-10 text-pos">
                                        <h6>Bradly</h6>
                                        <p>Our company has private jets of their own, but some meetings are too sensitive for the public, and this service allows us to fly anywhere without rumors hurting the stock price.</p>
                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>


                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
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
                            <div class="row col-md-12 pos-full">
                                <div class="col-md-1 line-border">
                                    <svg width="3" height="270" viewBox="0 0 3 364" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.1" width="3" height="364" fill="#4c4d4c"/>
                                    </svg>

                                </div>
                                
                                <div class="col-md-11 position">
                                    <p class="mt-3 mb-3">JetOnset is the first platform in the world to allow you to comfortably fly on a private jet without having to own one. You can book on the 1700 plus private jets in the shortest time possible. Select from the four categories outlined; light jets, mid-size jets, long-range (heavy jets), and short-range turboprops for your appropriate fit. 
                                        </p>
                                    <p class="mt-3 mb-3">We guarantee you the best fit with the lowest prices on booking, for each jet category. Once you have your best jet choice, confirm your booking by paying either by Bitcoin, Credit card, Etherium, or wired transfer. Your flight is approved, and you can go ahead and start planning for your travel.</p>    
                                    <p class="mb-0"><strong>We offer you three convenient options:</strong></p>
                                    <p class="mb-0"><strong>Door to Door</strong> - You are picked up from your doorstep and dropped at the doorstep of your destination.</p>
                                    <p class="mb-0"><strong>Airport to Airport</strong> - From your departure airport to your arrival airport, everything is personally managed.</p>
                                    <p class="mb-0"><strong>Flight Auctions</strong> - If your schedule is flexible; there are discounted prices for sale available for you.</p>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq2" role="button" aria-expanded="false" aria-controls="collapseFaq2">How Much Does Private Charter Jet Cost?</a>
                        <div class="collapse" id="collapseFaq2">
                            <div class="row col-md-12 pos-full">
                                <div class="col-md-1 line-border mt-3">
                                    <svg width="3" height="80" viewBox="0 0 3 364" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.1" width="10" height="364" fill="#4c4d4c"/>
                                    </svg>
                                </div>
                                <div class="col-md-11 position">
                                    <p class="mt-3 mb-0">JetOnset looks into its over 1700 available jets on the dates you are placing your reservation, and we ensure you get the lowest price possible. If you find another jet flight for less than we offer you, we will match the price and give you a 5% discount, if it is the same jet type, and the same travel route at the same time and date as yours.</p>
                                </div>
                                </div>    
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                        <div class="card-body">
                            <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq3" role="button" aria-expanded="false" aria-controls="collapseFaq3">Where To Charter A Private Jet?</a>
                            <div class="collapse" id="collapseFaq3">
                            <div class="row col-md-12 pos-full">
                                    <div class="col-md-1 line-border mt-3">
                                        <svg width="5" height="50" viewBox="0 0 3 364" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.1" width="10" height="364" fill="#4c4d4c"/>
                                        </svg>
                                    </div>
                                    <div class="col-md-11 position">
                                        <p class="mt-3 mb-0">JetOnset stays with you every step of the way and does not need any membership commitments. Also, with JetOnset, you only pay for your airtime, no more and no less. You are relaxing when the jet engine begins to when it stops.</p>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="card mb-3">
                        <div class="card-body">
                            <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq4" role="button" aria-expanded="false" aria-controls="collapseFaq4">Why Charter A Private Jet?</a>
                            <div class="collapse" id="collapseFaq4">
                                <div class="row col-md-12 pos-full">
                                    <div class="col-md-1 line-border mt-4">
                                        <svg width="5" height="60" viewBox="0 0 3 364" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.1" width="10" height="364" fill="#4c4d4c"/>
                                        </svg>
                                    </div>
                                    <div class="col-md-11 position">
                                        <p class="mt-3 mb-0">There are many reasons people and organizations charter private jets. It could be a romantic getaway for a grand honeymoon. It could also be a corporate retreat to reward your executives and employees. Some companies own their own planes and use these to avoid creating rumors as they visit their manufacturing facility unannounced.</p>
                            
                                    </div>
                            </div>        
                        </div>
                    </div>
                </div>    
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq5" role="button" aria-expanded="false" aria-controls="collapseFaq5">How Long To Charter A Private Jet?</a>
                        <div class="collapse" id="collapseFaq5">
                            <div class="row col-md-12 pos-full">
                                <div class="col-md-1 line-border mt-4">
                                    <svg width="5" height="40" viewBox="0 0 3 364" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.1" width="10" height="364" fill="#4c4d4c"/>
                                    </svg>
                                </div>
                                <div class="col-md-11 position">
                                    <p class="mt-3 mb-0">JetOnset operates around the clock, and booking two hours before departure is okay, but maybe affected by positions that may arise. Booking in advance is advised.</p>
                    
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq6" role="button" aria-expanded="false" aria-controls="collapseFaq6">Can I Charter A Private Jet?</a>
                        <div class="collapse" id="collapseFaq6">
                            <div class="row">
                                
                                <div class="col-md-12 ">
                                    <p class="mt-3 mb-0">As long as you aren’t on a No-Fly List and have the funds available to pay for the service, you absolutely can!</p>
                                </div>
                            </div>        
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

@push('scripts')
    <script type="text/javascript">

        $(function() {

            $('.carousel').carousel({
                interval: 25000
            });

            $('input[name="departure"]').daterangepicker({
                opens: 'left',

            });


            $('input.from').typeahead({

                source:  function (query, process) {
                    console.log(query);
                    return $.get("/api/airports", { query: query }, function (data) {
                        return process(data);
                    });
                }
            });
            $('input.to').typeahead({

                source:  function (query, process) {
                    return $.get("/api/airports", { query: query }, function (data) {
                        return process(data);
                    });
                }
            });

        });
    </script>

@endpush
