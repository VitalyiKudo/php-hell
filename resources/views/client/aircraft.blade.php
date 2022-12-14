@extends('client.layouts.app')
@section('meta')
<title>Private Chartered Jets & Planes | JetOnset</title>
    <meta name="description" content="Find out how it works here at JetOnset and see our fleet of private chartered jets and planes!">
@endsection

@section('content')

<div class="section header-page-image"></div>

<div class="section aircraft-title">
    <div class="container">
        <div class="row txt-pos">
            <div class="col">
                <h2 class="mb-3">Private Aircraft Categories</h2>
                <p class="mb-5 aircraft-cat">With JetOnset you have access to <strong> thousands of planes</strong> positioned across the world, all accessible at your own fingertips. Take a journey through the wide variety of classes and options we can bring to you, at a fraction of the cost. These range from small propeller driven planes to VIP Airliners designed for professional Sports Teams and celebrities. </p>
            </div>
        </div>
    </div>
</div>

<div class="section aircraft-planes">
    <div class="container">
        <div class="row txt-pos2">
            <div class="col planes-block">
                <ul class="nav nav-tabs new-nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link link-txt" id="heavy-jets-tab" data-toggle="tab" href="#heavy-jets" role="tab" aria-controls="heavy-jets" aria-selected="false">Heavy Jet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-txt" id="mid-size-jets-tab" data-toggle="tab" href="#mid-size-jets" role="tab" aria-controls="mid-size-jets" aria-selected="false">Mid-size Jet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-txt" id="light-jets-tab" data-toggle="tab" href="#light-jets" role="tab" aria-controls="light-jets" aria-selected="false">Light Jet</a>
                    </li>
                    <li class="nav-item turbopop">
                        <a class="nav-link last-nav-link link-txt" id="turbopop-tab" data-toggle="tab" href="#turbopop" role="tab" aria-controls="turbopop" aria-selected="false">Turbo Prop</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container sec-size">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active tab-click" id="vip-airliner" role="tabpanel" aria-labelledby="vip-airliner-tab">
                <div class="row fixed-row">
                    <div class="col-md-12 bg-plane">
                        <div class="size-width">
                            <img class="d-block plane-pos" loading="lazy" src="/images/aircrafts/jet_types_8.png" alt="First slide">
                        </div>
                        <!-- <div class="size-width">
                            <p class="plane-tab upcase">VIP Airliner</p>
                            <p class="mb-0 plane-tab-2">There are many good reasons why this class is called VIP Airliner, and that???s because they truly live up to their name. These jets have been designed for VIP???s from the ground up. Featuring a private bedroom, customized styling for all interiors, these planes are often used by Sports Teams and celebrities alike.
                                <span class="extra_text">They can take you and your company anywhere you need to go, with a carrying capacity of over 100 passengers. They can travel 7,500 miles, unlocking limitless destinations for your next corporate retreat or your next concert hall. These are the crown jewels of the Airbus and Boeing Aircraft lines, and are truly something to behold.</span>
                            </p>
                            <div class="rd-more-section">

                            </div>


                            <div class="div-plane-details">
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Passengers</span>
                                    <span class='main-text'>5-8</span>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Bags</span>
                                    <div>
                                        <span class='main-text'>60-305</span>
                                        <span class="scale">ft<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Range</span>
                                    <div>
                                        <span class='main-text'>22315-3700</span>
                                        <span class="scale">km</span>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="size-width">
                            <p class="mb-0 plane-tab upcase">Heavy Jet</p>
                            <p class="mb-0 plane-tab-2">The Heavy Jets are getting closer in appearance to large commercial aircraft, and can hold a capacity of 18 passengers. These are complete with the luxurious amenities often found on commercial airliners as well as a potential 10 hour duration capacity of flight.
                                <span class="extra_text"> These are the most common planes used for intercontinental flights due to their 4,000 mile range and are a favorite among the elite.</span></p>
                            <div class="rd-more-section">

                        </div>


                            <div class="div-plane-details">
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Passengers</span>
                                    <span class='main-text'>1-16</span>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Bags</span>
                                    <div>
                                        <span class='main-text'>226</span>
                                        <span class="scale">ft<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Cruise speed</span>
                                    <div>
                                        <span class='main-text'>562</span>
                                        <span class="scale">mph</span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Range</span>
                                    <div>
                                        <span class='main-text'>8000</span>
                                        <span class="scale">miles</span>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="row txt-pos3 fixed-row">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header "> VIP Airliner  </span>
                        <span class="flight-header2"> fleet  </span>
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm-4">
                                    <p> Beechjet 400 </p>
                                    <p> Citation Bravo </p>
                                    <p> Citation CJ1 </p>
                                    <p> Citation CJ1+</p>

                                </div>
                                <div class="col-sm-4">

                                    <p> Citation CJ2</p>
                                    <p> Citation CJ2+</p>
                                    <p> Citation CJ3</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade tab-click " id="ultra-long-range-jets" role="tabpanel" aria-labelledby="ultra-long-range-jets-tab">
                <div class="row fixed-row">
                    <div class="row fixed-row">
                        <div class="col-md-12 bg-plane">
                            <div class="size-width">
                                <img class="d-block plane-pos" loading="lazy" src="/images/aircrafts/jet_types_7.png" alt="First slide">
                            </div>
                            <div class="size-width">
                                <p class="mb-0 plane-tab upcase">Ultra Long Range</p>
                                <p class="mb-0 plane-tab-2">These Ultra Long Range Jets are what you need if you are flying around the world. These are the most common types of jets used for flights that will last over 12 hours, and have a carrying capacity of up to 19 passengers.
                                    <span class="extra_text">If your business or family is looking for a non-stop option to travel around the world, this is your safest bet. Coincidentally with the rise and popularity of private jet charters, these are the newest class of aircraft to join the marketplace.</span>
                                </p>

                                <div class="rd-more-section">

                                </div>

                                <div class="div-plane-details">
                                    <div class="div-plane-details-colums">
                                        <span class='sub-text'>Passengers</span>
                                        <span class='main-text'>5-8</span>
                                    </div>
                                    <div class="div-plane-details-colums">
                                        <span class='sub-text'>Max Bags</span>
                                        <div>
                                            <span class='main-text'>60-74</span>
                                            <span class="scale">ft<sup>3</sup></span>
                                        </div>
                                    </div>
                                    <div class="div-plane-details-colums">
                                        <span class='sub-text'>Max Range</span>
                                        <div>
                                            <span class='main-text'>2408-3475</span>
                                            <span class="scale">km</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row fixed-row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Ultra Long Range Jet </span>
                        <span class="flight-header2"> fleet  </span>
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm-4">

                                    <p> Citation CJ1+</p>
                                    <p> Citation CJ2</p>
                                </div>
                                <div class="col-sm-4">
                                    <p> Citation CJ2+</p>
                                    <p> Citation CJ3</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade tab-click" id="heavy-jets" role="tabpanel" aria-labelledby="heavy-jets-tab">
                <div class="row fixed-row">
                    <div class="col-md-12 bg-plane2">
                        <div class="size-width">
                            <img class="d-block plane-pos" loading="lazy" src="/images/aircrafts/jet_types_6.png" alt="First slide">
                        </div>
                        <div class="size-width">
                            <p class="mb-0 plane-tab upcase">Heavy Jet</p>
                            <p class="mb-0 plane-tab-2">The Heavy Jets are getting closer in appearance to large commercial aircraft, and can hold a capacity of 18 passengers. These are complete with the luxurious amenities often found on commercial airliners as well as a potential 10 hour duration capacity of flight.
                                <span class="extra_text"> These are the most common planes used for intercontinental flights due to their 4,000 mile range and are a favorite among the elite.</span></p>
                            <div class="rd-more-section">

                            </div>


                            <div class="div-plane-details">
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Passengers</span>
                                    <span class='main-text'>1-16</span>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Bags</span>
                                    <div>
                                        <span class='main-text'>226</span>
                                        <span class="scale">ft<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Cruise speed</span>
                                    <div>
                                        <span class='main-text'>562</span>
                                        <span class="scale">mph</span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Range</span>
                                    <div>
                                        <span class='main-text'>8000</span>
                                        <span class="scale">miles</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row txt-pos3">

                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Heavy Jet </span>
                        <span class="flight-header2"> fleet  </span>
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm-4">
                                    <p> Hawker 4000</p>
                                    <p> Legacy 600</p>
                                    <p> Gulfstream 5</p>
                                    <p> Gulfstream 4</p>
                                    <p> Gulfstream G450</p>
                                    <p> Global 6000</p>
                                    <p> Falcon 900</p>
                                </div>
                                <div class="col-sm-4">
                                    <p> Falcon 7X</p>
                                    <p> Falcon 2000</p>
                                    <p> Embraer lineage 1000</p>
                                    <p> Challenger 605</p>
                                    <p> Challenger 604</p>
                                    <p> Challenger 601</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane tab-click " id="super-mid-size-jets" role="tabpanel" aria-labelledby="super-mid-size-jets-tab">
                <div class="row fixed-row">
                    <div class="col-md-12 bg-plane2">
                        <div class="size-width">
                            <img class="d-block plane-pos" loading="lazy" src="/images/aircrafts/jet_types_5.png" alt="First slide">
                        </div>
                        <div class="size-width">
                            <p class="mb-0 plane-tab upcase">Super Midsize Jet</p>
                            <p class="mb-0 plane-tab-2">The Super Midsize Jets are the Goldilocks of the businessman's private jet experience. Often referred to as the most effective in getting the best bang for your buck, these planes are equipped with the luxurious amenities often only found on larger commercial airliners but can accommodate 10 passengers.
                                <span class="extra_text">These planes will have bathrooms and larger luggage capacity. The distance and the duration are also slightly better than the Midsize Jets with a range of up to 2,500 miles in one direction.</span></p>
                            <div class="rd-more-section">

                            </div>


                            <div class="div-plane-details">
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Passengers</span>
                                    <span class='main-text'>5-8</span>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Bags</span>
                                    <div>
                                        <span class='main-text'>24-428</span>
                                        <span class="scale">ft<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Range</span>
                                    <div>
                                        <span class='main-text'>2130-3720</span>
                                        <span class="scale">km</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Super Midsize Jet </span>
                        <span class="flight-header2"> fleet  </span>
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm-4">
                                     <p> Citation Mustang</p>
                                    <p> Citation S / II</p>
                                    <p> Citation Ultra</p>
                                    <p> Citation V</p>

                                </div>
                                <div class="col-sm-4">
                                    <p> Citation Hawker 400XP</p>
                                    <p> Honda Jet</p>
                                    <p> Learjet 35A</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane tab-click" id="mid-size-jets" role="tabpanel" aria-labelledby="mid-size-jets-tab">
                <div class="row fixed-row">
                    <div class="col-md-12 bg-plane3">
                        <div class="size-width">
                            <img class="d-block plane-pos" loading="lazy" src="/images/aircrafts/jet_types_4.png" alt="First slide">
                        </div>
                        <div class="size-width">
                            <p class="mb-0 plane-tab upcase">Midsize Jet</p>
                            <p class="mb-0 plane-tab-2">These midsize jets are where things get interesting. These can travel up to 4 hours in one direction, and all models are equipped with luxuries and even bathrooms onboard. These can accommodate 9 passengers and can travel 2,000 miles in one direction.
                                <span class="extra_text"> These are among the most common planes used for business purposes regarding executives and critical meetings.</span></p>
                            <div class="rd-more-section">

                            </div>
                            <div class="div-plane-details">
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Passengers</span>
                                    <span class='main-text'>1-11</span>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Bags</span>
                                    <div>
                                        <span class='main-text'>125</span>
                                        <span class="scale">ft<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Cruise speed</span>
                                    <div>
                                        <span class='main-text'>603</span>
                                        <span class="scale">mph</span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Range</span>
                                    <div>
                                        <span class='main-text'>4000</span>
                                        <span class="scale">miles</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Midsize Jet </span>
                        <span class="flight-header2"> fleet  </span>
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm-4">
                                    <p> Challenger 300</p>
                                    <p> Citation excel</p>
                                    <p> Citation 3</p>
                                    <p> Citation latitude</p>
                                    <p> Citation sovereign</p>
                                    <p> Citation 7</p>
                                    <p> Citation 10</p>
                                    <p> Falcon 20</p>
                                    <p> Falcon 50</p>
                                </div>
                                <div class="col-sm-4">
                                    <p> G150 Astra</p>
                                    <p> Gulfstream G200</p>
                                    <p> Hawker 100</p>
                                    <p> Hawker 800</p>
                                    <p> Learjet 55</p>
                                    <p> Learjet 60</p>
                                    <p> Legacy 450</p>
                                    <p> Sebreliner 75</p>
                                    <p> Westwind 2</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane tab-click" id="light-jets" role="tabpanel" aria-labelledby="light-jets-tab">
                <div class="row fixed-row">
                    <div class="col-md-12 bg-plane3">
                        <div class="size-width">
                            <img class="d-block plane-pos2" loading="lazy" src="/images/aircrafts/jet_types_3.png" alt="First slide">
                        </div>
                        <div class="size-width">
                            <p class="mb-0 plane-tab upcase">Light Jets</p>
                            <p class="mb-0 plane-tab-2">The Light Jet class is often the smallest used for business purposes, but can often fit up to 6 passengers at once. These planes will come standard with luxurious seats that can recline as well as temperature and humidity control onboard. These are often used for short-range trips of 1,000 miles, or two hours.
                                <span class="extra_text">These limitations might be able to be greatly lengthened depending on the number of passengers or weight of what you???ll be bringing along  the ride.</span></p>

                            <div class="rd-more-section">

                            </div>
                            <div class="div-plane-details">
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Passengers</span>
                                    <span class='main-text'>1-8</span>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Bags</span>
                                    <div>
                                        <span class='main-text'>45</span>
                                        <span class="scale">ft<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Cruise speed</span>
                                    <div>
                                        <span class='main-text'>534</span>
                                        <span class="scale">mph</span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Range</span>
                                    <div>
                                        <span class='main-text'>2700</span>
                                        <span class="scale">miles</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Light Jets </span>
                        <span class="flight-header2"> fleet  </span>
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm-4">
                                    <p> Phenom 300</p>
                                    <p> Phenom 100</p>
                                    <p> Sabreliner 40</p>
                                    <p> Learjet 45</p>
                                    <p> Learjet 36a</p>
                                    <p> Learjet 35</p>
                                    <p> Learjet 31</p>
                                    <p> Hawker 400</p>
                                    <p> Falcon 10/100</p>
                                    <p> Eclipse 500</p>
                                </div>
                                <div class="col-sm-4">
                                    <p> Citation v encore</p>
                                    <p> Citation 5</p>
                                    <p> Citation ultra</p>
                                    <p> Citation mustang</p>
                                    <p> Citation 1</p>
                                    <p> Citation CJ4</p>
                                    <p> Citation CJ3</p>
                                    <p> Citation bravo</p>
                                    <p> Cessna CJ2</p>
                                    <p> Beechcraft 400 XP</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade tab-click" id="entry-level-jet" role="tabpanel" aria-labelledby="entry-level-jet-tab">
                <div class="row fixed-row">
                    <div class="col-md-12 bg-plane4">
                        <div class="size-width">
                            <img class="d-block plane-pos2" loading="lazy" src="/images/aircrafts/jet_types_2.png" alt="First slide">
                        </div>
                        <div class="size-width">
                            <p class="mb-0 plane-tab upcase">Entry-level Jet</p>
                            <p class="mb-0 plane-tab-2">This class of jet is slightly larger than the Turboprop and is the smallest plane class without propellers. This plane can still access small runways as well as major airports. The carrying capacity can range from 4-5 passengers and are equipped with some amenities.
                                <span class="extra_text"> The most common limitation on this class is the carrying capacity of 10,000 pounds, however, these flights can travel 750 miles in one direction.</span></p>
                            <div class="rd-more-section">

                            </div>
                            <div class="div-plane-details">
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Passengers</span>
                                    <span class='main-text'>6-8</span>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Bags</span>
                                    <div>
                                        <span class='main-text'>67-78</span>
                                        <span class="scale">ft<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Range</span>
                                    <div>
                                        <span class='main-text'>2434-4010</span>
                                        <span class="scale">km</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Entry-level Jet </span>
                        <span class="flight-header2"> fleet  </span>
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm-4">
                                    <p> Learjet 55</p>
                                    <p> Phenom 300</p>
                                </div>
                                <div class="col-sm-4">
                                    <p> Premier I</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade tab-click" id="turbopop" role="tabpanel" aria-labelledby="turbopop-tab">
                <div class="row fixed-row">
                    <div class="col-md-12 bg-plane4">
                        <div class="size-width">
                            <img class="d-block plane-pos2" loading="lazy" src="/images/aircrafts/jet_types_1.png" alt="First slide">
                        </div>
                        <div class="size-width">
                            <p class="mb-0 plane-tab upcase">Turbo prop</p>
                            <p class="mb-0 plane-tab-2">Turboprops are the smallest class of jets and they are the most efficient plane for low altitude flights and typically operate below 450 miles.
                                <span class="extra_text"> They are the most cost-efficient option and are often used for flights with an approximate duration of two hours and can land at both short runways as well as major airports.</span></p>
                            <div class="rd-more-section">

                            </div>
                            <div class="div-plane-details">
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Passengers</span>
                                    <span class='main-text'>1-12</span>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Bags</span>
                                    <div>
                                        <span class='main-text'>28</span>
                                        <span class="scale">ft<sup>3</sup></span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Cruise speed</span>
                                    <div>
                                        <span class='main-text'>360</span>
                                        <span class="scale">mph</span>
                                    </div>
                                </div>
                                <div class="div-plane-details-colums">
                                    <span class='sub-text'>Max Range</span>
                                    <div>
                                        <span class='main-text'>2500</span>
                                        <span class="scale">miles</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Turbo prop </span>
                        <span class="flight-header2"> fleet  </span>
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm-4">
                                    <p> Piper Cheyenne 4</p>
                                    <p> Pilatus PC12</p>
                                    <p> Merlin 3B</p>
                                    <p> King air 90</p>

                                </div>
                                <div class="col-sm-4">
                                    <p> King air 350</p>
                                    <p> King air 200</p>
                                    <p> TBM 850</p>
                                    <p> Cessna caravan 2</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <div class="container sec-style">
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade" id="turbopop" role="tabpanel" aria-labelledby="turbopop-tab">
                <div class="row fixed-row">
                    <div class="col">
                        <p class="mb-0 plane-tab upcase">Turbopop</p>
                        <p class="mb-0">Turboprops are the smallest class of jets and they are the most efficient plane for low altitude flights and typically operate below 450 miles. They are the most cost-efficient option and are often used for flights with an approximate duration of two hours and can land at both short runways as well as major airports.</p>
                    </div>
                </div>
                <div class="row align-items-center pt-4 pb-4">
                    <div class="col-5 offset-1">
                        <ul class="plane-list">
                            <li><p>King Air 90</p></li>
                            <li><p>King Air 200</p></li>
                            <li><p>King Air 250</p></li>
                            <li><p>King Air 350</p></li>
                            <li><p>PC-12</p></li>
                        </ul>
                    </div>
                    <div class="col-5">
                        <img src="/images/plane.jpg" loading="lazy" class="plane-img" alt="...">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="section concierge">
    <div class="container">
        <div class="row fixed-row">
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
    <script type="text/javascript">
        $(document).ready(function(){

            $('.extra_text').hide();

            $('.read-mores').click(function(e){
                e.preventDefault();
                $('.extra_text').toggle();
            });

        });
    </script>

@endpush
