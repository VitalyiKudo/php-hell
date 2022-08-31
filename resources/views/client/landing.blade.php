@extends('client.layouts.app')
@section('meta')
<title>Private Jet Charter | JetOnset</title>
    <meta name="description" content="JetOnset provides world class private jet charters that will change the way you fly forever.">
@endsection

@section('content')
{{--    <search-form></search-form>--}}

<div class="section main-search fix-content">
    <div class="container">
        <div class="row">
            <div class="offset-md-1">
                <form action="{{ route('client.flight.index') }}" method="GET" id="main-search-form">
                    @csrf
                    <div class="row form-body form-search-mobile">
                        <div class="col-lg-10 mb-2 mt-4 home-title">
                            <h1>Fly different today: Search your private jet</h1>
                        </div>
                        <div class="mb-3 mt-2 ml-3 start-point">
                            <div class="input-group input-style-3">
                                <input type="text"
                                    class="form-control from"
                                    placeholder="Departure Airport"
                                    aria-describedby="departure-airport"
                                    name="startPointName"
                                    autocomplete="off"
                                >
                                <input type="hidden" name="startPoint" autocomplete="off" value="">
                                <input type="hidden" name="startAirport" autocomplete="off" value="">
                                <div id="departureList"></div>
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="departure-airport">
                                    <img src="/images/departure-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-2 pl-0 bd end-point">
                            <div class="input-group input-style-2">
                                <input type="text"
                                    class="form-control to"
                                    placeholder="Arrival Airport"
                                    aria-describedby="arrival-airport"
                                    name="endPointName"
                                    autocomplete="off"
                                >
                                <input type="hidden" name="endPoint" autocomplete="off" value="">
                                <input type="hidden" name="endAirport" autocomplete="off" value="">
                                <div id="arrivalList"></div>
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="arrival-airport">
                                    <img src="/images/arrival-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-2 ml-3 dt-field">
                            <div class="input-group input-style">
                                <input type="text" class="form-control " name="flightDate" placeholder="Date&Time" autocomplete="off">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="date-time">
                                    <img src="/images/date-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3 mt-2 pl-0 ml-3 pass-field">
                            <div class="input-group input-style">
                                <input type="number" min="1" pattern="[0-9]*" class="form-control bd-input" placeholder="Passengers" aria-describedby="passengers" name="passengers" autocomplete="off">
                                <div class="input-group-prepend">
                                <span class="input-group-text bd-input" id="passengers" name="passengers" >
                                    <img src="/images/passengers-icon.svg" loading="lazy" class="icon-img" alt="..."></span>
                                </div>

                            </div>
                        </div>

                        <div class="form-container-1 mt-2 ml-3 butn-search">
                            <button type="submit" class="btn">Search Jet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="section mouse-top">
    <div class="container">
        <div class="row scroll-down-fix">
            <div class="col-12 mb-5 ml-5">
                <div class="col-5 float-left">
                    <a href="#how-it-works">

                        <img src="/images/scroll.svg" loading="lazy" class="scroll-button scroll-arrow" alt="..."  align="right">
                        <img src="/images/mouse.svg" loading="lazy" class="scroll-button scroll-mouse2 scroll-upper" align="right" alt="...">
                    </a>
                </div>
                <div class="col-7 mt-2">
                    <span class="scroll-txt">Scroll down</span>
                </div>
            </div>
        </div>
    </div>

</div>
{{--<flight></flight>--}}
<div class="section main-works" id="how-it-works">
    <div class="container no-padding">
        <div class="row">
            <div class="col-lg-12">
                <h2>How It Works</h2>
                <p class="font-weight-bold mb-3 simple-padding">It’s simple.</p>
                <p class="mb-0 text-justify">You choose where you want to go, when you want to go, and where you are coming from to get started. Next, we will show you every option available with an accurate price quote. Finally, you choose the private jet that fits your needs. It’s that simple.</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-search.svg" loading="lazy" class="card-img-top" alt="...">
                </div>
                <p class="card-text-h">Search</p>
                <p class="card-text-p"> for your flight</p>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.webp" loading="lazy" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-choose.svg" loading="lazy" class="card-img-top" alt="...">
                </div>
                <p class="card-text-h">Choose a flight</p>
                <p class="card-text-p">that fits you</p>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.webp" loading="lazy" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-book.svg" loading="lazy" class="card-img-top" alt="...">
                </div>
                <p class="card-text-h">Book</p>
                <p class="card-text-p">your flight</p>
            </div>
            <div class="col-lg-1">
                <img src="/images/devider.webp" loading="lazy" class="devider" alt="...">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card">
                    <img src="/images/works-wait.svg" loading="lazy" class="card-img-top" alt="...">
                </div>
                <p class="card-text-h">Wait for</p>
                <p class="card-text-p">Confirmation</p>
            </div>
            <div class="col-lg-1">
                <img src="/images/brown-devider.webp" loading="lazy"  alt="..." class="devider2">
            </div>
            <div class="col-lg-1 col-lg-1-5">
                <div class="card last-card">
                    <img src="/images/works-enjoy.svg" loading="lazy" class="card-img-top" alt="...">

                </div>
                <p class="card-text-h">Enjoy</p>
                <p class="card-text-p">your flight</p>
            </div>
        </div>
    </div>
</div>

<div class="section main-services">
    <div class="container">
        <div class="row">
            <div class="col mb-2 service-headline">
                <h2>Services</h2>
            </div>
        </div>
    </div>
    <div class="container services services-right mt-0">
        <div class="row">
            <div class="col-md-6 services-text">

                <h5 class="services-h2 ">Luxury Travel, Luxury Vacations</h5>
                <p class="services-p">You can’t experience luxury travel or luxury vacations by starting them off in economy class on a commercial airliner. With JetOnset, your luxurious getaways will get off on the right foot with a world-class experience on a private chartered jet. </p>
                <div class="row mt-5">
                    <div class="col-md-1 pr-md-0 service-fancy-separator"></div>
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
                <p class="services-p">Treat your executives or clients like the valued stakeholders that they are with the use of private jets and chartered planes for your next shareholder meeting. Have a once-in-a-lifetime client potential or want to treat your executives to a special treat? </p>

                <div class="row mt-5">
                    <div class="col-md-1 pr-md-0 service-fancy-separator"></div>
                    <div class="col-md-10 service-fancy-p">
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
                <p class = ' simple-padding'><strong>All Private Jets in your pocket</strong></p>
                <p class="mb-6 mobile-text-justify">Are you a frequent flyer and need the ultimate speed and flexibility in private jet travel? Try our Mobile App and get to where you need to go, even faster!</p>
                
            </div>
            
        </div>
    </div>
</div>

<div class="section main-about-us">
    <div class="container">
        <div class="row">
        <p>
        JetOnset is a team of IT and automation enthusiasts. We believe that the natural development of any industry should lead it towards greater transparency, industrial efficiency, and user-friendliness. Services must become easier and more accessible to more people to capture the opportunity only available at scale.
        The platform we are creating will significantly change the rules of the game for all market participants in the direction of maximizing its efficiency. It will cover several of the most important aspects of the private aviation market. Intermediary services in booking flights Recruitment and registration of aircrews Interaction between aircraft operators FBO Online analytics
        </p>
            <!-- <div class="col-md-12 mb-2">
                <h2>About JetOnset's Charter for Private Jets</h2>
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

                <div class="offset-5 col-md-3">
                    <a href="{{ url('about') }}" class="learn-more">More about JetOnset Co.</a>
                </div>

            </div> -->


        </div>
    </div>
</div>

<div class="section testimonials testimonials-landing">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators carousel-indicators2">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active" >
                            <div class="col-sm-10 offset-sm-1 col-12 text-bg">
                                <div class="col-md-12">
                                    <div class="col-md-2 img-pos">
                                        <img src="/images/slider/frank.webp" loading="lazy" class="testimonials-img align-self-center mr-2" alt="...">
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
                                        <img src="/images/slider/serg.webp" loading="lazy" class="testimonials-img align-self-center mr-2" alt="...">
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
                                        <img src="/images/slider/aleksander.webp" loading="lazy" class="testimonials-img align-self-center mr-2" alt="...">
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
                                        <img src="/images/slider/bradly.webp" loading="lazy" class="testimonials-img align-self-center mr-2" alt="...">
                                    </div>
                                    <div class="col-md-10 text-pos">
                                        <h6>Bradly</h6>
                                        <p>Our company has private jets of their own, but some meetings are too sensitive for the public, and this service allows us to fly anywhere without rumors hurting the stock price.</p>
                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>


                    <a class="carousel-control-prev carousel-control-prev2" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon carousel-control-prev-icon2 " aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next carousel-control-next2" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon carousel-control-next-icon2" aria-hidden="true"></span>
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
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq1" role="button" aria-expanded="false" aria-controls="collapseFaq1">What is private jet charter?
                        <i class="down"></i>
                        </a>
                        <div class="collapse" id="collapseFaq1">
                            <div class="row col-md-12 pos-full">
                                <div class="col-md-1 line-border">
                                    <svg width="2px" height="100%" preserveAspectRatio="none" viewBox="0 0 2 2" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                            <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq3" role="button" aria-expanded="false" aria-controls="collapseFaq3">Where to charter a private jet?
                            <i class="down"></i>
                            </a>
                            <div class="collapse" id="collapseFaq3">
                            <div class="row col-md-12 pos-full">
                                    <div class="col-md-1 line-border mt-3">
                                        <svg width="2px" height="100%" preserveAspectRatio="none"viewBox="0 0 2 2" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                            <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq4" role="button" aria-expanded="false" aria-controls="collapseFaq4">Why charter a private jet?
                            <i class="down"></i>
                            </a>
                            <div class="collapse" id="collapseFaq4">
                                <div class="row col-md-12 pos-full">
                                    <div class="col-md-1 line-border mt-4">
                                        <svg width="2px" height="100%" preserveAspectRatio="none"viewBox="0 0 2 2" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq5" role="button" aria-expanded="false" aria-controls="collapseFaq5">How long to charter a private jet?
                        <i class="down"></i>
                        </a>
                        <div class="collapse" id="collapseFaq5">
                            <div class="row col-md-12 pos-full">
                                <div class="col-md-1 line-border mt-4">
                                    <svg width="2px" height="100%" preserveAspectRatio="none"viewBox="0 0 2 2" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <a class="card-title font-weight-bold mb-0 collapsed" data-toggle="collapse" href="#collapseFaq6" role="button" aria-expanded="false" aria-controls="collapseFaq6">Can i charter a private jet?
                        <i class="down"></i>
                        </a>
                        <div class="collapse" id="collapseFaq6">
                            <div class="row col-md-12 pos-full">
                                <div class="col-md-1 line-border">
                                    <svg width="2px" height="100%" preserveAspectRatio="none" viewBox="0 0 2 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.1" width="3" height="364" fill="#4c4d4c"/>
                                    </svg>
                                </div>
                                <div class="col-md-11 position">
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

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
    <script type="text/javascript">
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

        $(function() {

            $('.carousel').carousel({
                interval: 25000
            });

            $('input[name="flightDate"]').daterangepicker({
                opens: 'left',
                keepEmptyValues: true,
                singleDatePicker: true,
                autoApply: true,
                autoUpdateInput: true,
                isInvalidDate: (e) => new Date(e) < today
            });
            $('input[name="flightDate"]').val('');
            $('input[name="flightDate"]').attr("placeholder","Date & Time");


            $('input.from').keyup(function(){
                var query = $(this).val();

                if(query != '' && query.length >= 3){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "/api/airports",
                        method: "GET",
                        data: {query:query, _token:_token},
                        obj: {query:query, _token:_token},
                        success: function(data){
                            var lookup = {};
                            var output = '<ul class="dropdown-menu">';

                            if (data.length !== 0){
                                $.each(data, function(idx, obj) {
                                    var city = (!$.isEmptyObject(obj.city)) ? obj.city : '';
                                    var region = (!$.isEmptyObject(obj.region)) ? obj.region + ', ' : '';
                                    var country = (!$.isEmptyObject(obj.country)) ? obj.country : '';
                                    var area = (!$.isEmptyObject(obj.area)) ? obj.area : '';
                                    var objAirport = obj.airport;

                                    output += '<div>' + '<span>' + city + ' ('+ area +')</span><span>' + region + country + '</span>' + '</div>';

                                    $.each(objAirport, function(k, val) {
                                        var iata = (!$.isEmptyObject(val.iata)) ? '(' + val.iata + ')': '';
                                        output += '<li><a href="' + obj.id + '">' +
                                            '<div>'+ '<span>'+ val.name +'</span>' + '<span><icao>' + val.icao + '</icao>' + iata + '</span>' + '</div>' +
                                            '</a></li>';
                                    });

                                });
                            }
                            else {
                                output += '<li>No matches found</li>';
                            }
                            output += '</ul>';
                            $('#departureList').fadeIn();
                            $('#departureList').html(output).mark(query);
                        }
                    });
                }
            });

            $(document).on('click', '#departureList li', function(e){
                e.preventDefault();
                $('input.from').val($(this).find('span:first').text());
                $('input[name="startPoint"]').val($(this).find('a:first').attr('href'));
                $('input[name="startAirport"]').val($(this).find('icao:first').text());
                $('#departureList').fadeOut();
            });

            $('input.to').keyup(function(){
                var query = $(this).val();

                if(query != '' && query.length >= 3){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "/api/airports",
                        method: "GET",
                        data: {query:query, _token:_token},
                        success: function(data){
                            var lookup = {};
                            var output = '<ul class="dropdown-menu">';

                            if (data.length !== 0){
                                $.each(data, function(idx, obj) {
                                    var city = (!$.isEmptyObject(obj.city)) ? obj.city : '';
                                    var region = (!$.isEmptyObject(obj.region)) ? obj.region + ', ' : '';
                                    var country = (!$.isEmptyObject(obj.country)) ? obj.country : '';
                                    var area = (!$.isEmptyObject(obj.area)) ? obj.area : '';
                                    var objAirport = obj.airport;

                                    output += '<div>' + '<span>' + city + ' ('+ area +')</span><span>' + region + country + '</span>' + '</div>';

                                    $.each(objAirport, function(k, val) {
                                        var iata = (!$.isEmptyObject(val.iata)) ? '(' + val.iata + ')': '';
                                        output += '<li><a href="' + obj.id + '">' +
                                            '<div>'+ '<span>'+ val.name +'</span>' + '<span><icao>' + val.icao + '</icao>' + iata + '</span>' + '</div>' +
                                            '</a></li>';
                                    });

                                });
                            }
                            else {
                                output += '<li>No matches found</li>';
                            }
                            output += '</ul>';
                            $('#arrivalList').fadeIn();
                            $('#arrivalList').html(output).mark(query);
                        }
                    });
                }
            });

            $(document).on('click', '#arrivalList li', function(e){
                e.preventDefault();
                $('input.to').val($(this).find('span:first').text());
                $('input[name="endPoint"]').val($(this).find('a:first').attr('href'));
                $('input[name="endAirport"]').val($(this).find('icao:first').text());
                $('#arrivalList').fadeOut();
            });


            $('body').on('click', function(){
                $('#departureList').fadeOut();
                $('#arrivalList').fadeOut();
            });


            $('#main-search-form').submit(function(e){

                var start_point = $(this).find('input[name="startPoint"]').val();
                var end_point = $(this).find('input[name="endPoint"]').val();
                var flight_date = $(this).find('input[name="flightDate"]').val();
                var passengers = $(this).find('input[name="passengers"]').val();
                var html_message = '<span class="search-error">This field is required.</span>';
                var nowDate = new Date();
                var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate() + 2, 0, 0, 0, 0);

                if(start_point.length <= 0 || end_point.length <= 0 || flight_date.length <= 0 || passengers.length <= 0){
                    $('.search-error').remove();

                    if(start_point.length <= 0){
                        $(this).find('input[name="startPoint"]').parent('div').append(html_message);
                    }
                    if(end_point.length <= 0){
                        $(this).find('input[name="endPoint"]').parent('div').append(html_message);
                    }
                    if(flight_date.length <= 0){
                        $(this).find('input[name="flightDate"]').parent('div').append(html_message);
                    }
                    if(flight_date.length && new Date(flight_date) < today){
                        $(this).find('input[name="flightDate"]').parent('div').append('<span class="search-error">Choose another date</span>');
                    }
                    if(passengers.length <= 0){
                        $(this).find('input[name="passengers"]').parent('div').append(html_message);
                    }
                    e.preventDefault();
                }
            });


        });
    </script>

@endpush
