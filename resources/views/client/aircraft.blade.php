@extends('client.layouts.app')
@section('meta')
<title>Private Chartered Jets & Planes | JetOnset</title>
    <meta name="description" content="Find out how it works here at JetOnset and see our fleet of private chartered jets and planes!">
@endsection

@section('content')

<div class="section header-page-image"></div>

<div class="section aircraft-title">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="mb-3">Private Chartered Jets & Planes</h1>
                <p class="mb-0">With JetOnset you have access to thousands of planes positioned across the world, all accessible at your own fingertips. Take a journey through the wide variety of classes and options we can bring to you, at a fraction of the cost. These range from small propeller driven planes to VIP Airliners designed for professional Sports Teams and celebrities. </p>
            </div>
        </div>
    </div>
</div>

<div class="section aircraft-planes">
    <div class="container">
        <div class="row">
            <div class="col planes-block">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="vip-airliner-tab" data-toggle="tab" href="#vip-airliner" role="tab" aria-controls="vip-airliner" aria-selected="true">VIP airliner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ultra-long-range-jets-tab" data-toggle="tab" href="#ultra-long-range-jets" role="tab" aria-controls="ultra-long-range-jets" aria-selected="false">Ultra Long Range Jets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="heavy-jets-tab" data-toggle="tab" href="#heavy-jets" role="tab" aria-controls="heavy-jets" aria-selected="false">Heavy Jets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="super-mid-size-jets-tab" data-toggle="tab" href="#super-mid-size-jets" role="tab" aria-controls="super-mid-size-jets" aria-selected="false">Super Mid-size Jets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="mid-size-jets-tab" data-toggle="tab" href="#mid-size-jets" role="tab" aria-controls="mid-size-jets" aria-selected="false">Mid-size Jets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="light-jets-tab" data-toggle="tab" href="#light-jets" role="tab" aria-controls="light-jets" aria-selected="false">Light Jets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="entry-level-jet-tab" data-toggle="tab" href="#entry-level-jet" role="tab" aria-controls="entry-level-jet" aria-selected="false">Entry-level jet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link last-nav-link" id="turbopop-tab" data-toggle="tab" href="#turbopop" role="tab" aria-controls="turbopop" aria-selected="false">Turbopop</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="vip-airliner" role="tabpanel" aria-labelledby="vip-airliner-tab">
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 plane-tab">VIP airliner</p>
                                <p class="mb-0">There are many good reasons why this class is called VIP Airliner, and that’s because they truly live up to their name. These jets have been designed for VIP’s from the ground up. Featuring a private bedroom, customized styling for all interiors, these planes are often used by Sports Teams and celebrities alike. They can take you and your company anywhere you need to go, with a carrying capacity of over 100 passengers. They can travel 7,500 miles, unlocking limitless destinations for your next corporate retreat or your next concert hall. These are the crown jewels of the Airbus and Boeing Aircraft lines, and are truly something to behold.</p>
                            </div>
                        </div>
                        <div class="row align-items-center pt-4 pb-4">
                            <div class="col-md-5 offset-md-1 plane-block">
                                <ul class="plane-list">
                                    <li><p>Airbus 319</p></li>
                                    <li><p>Airbus ACJ</p></li>
                                    <li><p>Boeing 737-500</p></li>
                                    <li><p>Boeing BBJ</p></li>
                                    <li><p>Dornier 328</p></li>
                                    <li><p>Lineage 1000</p></li>
                                </ul>
                            </div>
                            <div class="col-md-5 col-8 m-auto">
                                <img src="/images/plane.jpg" class="plane-img" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ultra-long-range-jets" role="tabpanel" aria-labelledby="ultra-long-range-jets-tab">
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 plane-tab">Ultra Long Range Jets</p>
                                <p class="mb-0">These Ultra Long Range Jets are what you need if you are flying around the world. These are the most common types of jets used for flights that will last over 12 hours, and have a carrying capacity of up to 19 passengers. If your business or family is looking for a non-stop option to travel around the world, this is your safest bet. Coincidentally with the rise and popularity of private jet charters, these are the newest class of aircraft to join the marketplace.</p>
                            </div>
                        </div>
                        <div class="row align-items-center pt-4 pb-4">
                            <div class="col-5 offset-1">
                                <ul class="plane-list">
                                    <li><p>Falcon 7X</p></li>
                                    <li><p>Falcon 8X</p></li>
                                    <li><p>G V</p></li>
                                    <li><p>G-500</p></li>
                                    <li><p>G-550</p></li>
                                    <li><p>G-600</p></li>
                                    <li><p>G-650</p></li>
                                    <li><p>G-650ER</p></li>
                                    <li><p>Global 5000</p></li>
                                    <li><p>Global 6000</p></li>
                                    <li><p>Global 7000</p></li>
                                    <li><p>Global Express/XRS</p></li>
                                </ul>
                            </div>
                            <div class="col-5">
                                <img src="/images/plane.jpg" class="plane-img" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="heavy-jets" role="tabpanel" aria-labelledby="heavy-jets-tab">
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 plane-tab">Heavy Jets</p>
                                <p class="mb-0">The Heavy Jets are getting closer in appearance to large commercial aircraft, and can hold a capacity of 18 passengers. These are complete with the luxurious amenities often found on commercial airliners as well as a potential 10 hour duration capacity of flight. These are the most common planes used for intercontinental flights due to their 4,000 mile range and are a favorite among the elite.</p>
                            </div>
                        </div>
                        <div class="row align-items-center pt-4 pb-4">
                            <div class="col-5 offset-1">
                                <ul class="plane-list">
                                    <li><p>Challenger 601</p></li>
                                    <li><p>Challenger 604</p></li>
                                    <li><p>Challenger 605</p></li>
                                    <li><p>Challenger 850</p></li>
                                    <li><p>Falcon 2000</p></li>
                                    <li><p>Falcon 2000EX</p></li>
                                    <li><p>Falcon 2000LX</p></li>
                                    <li><p>Falcon 900</p></li>
                                    <li><p>Falcon 900EX</p></li>
                                    <li><p>G IV</p></li>
                                    <li><p>G IV-SP</p></li>
                                    <li><p>G-350</p></li>
                                </ul>
                            </div>
                            <div class="col-5">
                                <img src="/images/plane.jpg" class="plane-img" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="super-mid-size-jets" role="tabpanel" aria-labelledby="super-mid-size-jets-tab">
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 plane-tab">Super Midsize Jets</p>
                                <p class="mb-0">The Super Midsize Jets are the Goldilocks of the businessman's private jet experience. Often referred to as the most effective in getting the best bang for your buck, these planes are equipped with the luxurious amenities often only found on larger commercial airliners but can accommodate 10 passengers. These planes will have bathrooms and larger luggage capacity. The distance and the duration are also slightly better than the Midsize Jets with a range of up to 2,500 miles in one direction.</p>
                            </div>
                        </div>
                        <div class="row align-items-center pt-4 pb-4">
                            <div class="col-5 offset-1">
                                <ul class="plane-list">
                                    <li><p>Challenger 300</p></li>
                                    <li><p>Challenger 350</p></li>
                                    <li><p>Citation Latitude</p></li>
                                    <li><p>Citation Sovereign</p></li>
                                    <li><p>Citation Sovereign+</p></li>
                                    <li><p>Citation X</p></li>
                                    <li><p>Citation X+</p></li>
                                    <li><p>Falcon 50</p></li>
                                    <li><p>Falcon 50EX</p></li>
                                    <li><p>G-200</p></li>
                                    <li><p>G-280</p></li>
                                    <li><p>Hawker 1000</p></li>
                                    <li><p>Hawker 4000</p></li>
                                    <li><p>Legacy 450</p></li>
                                </ul>
                            </div>
                            <div class="col-5">
                                <img src="/images/plane.jpg" class="plane-img" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="mid-size-jets" role="tabpanel" aria-labelledby="mid-size-jets-tab">
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 plane-tab">Midsize Jets</p>
                                <p class="mb-0">These midsize jets are where things get interesting. These can travel up to 4 hours in one direction, and all models are equipped with luxuries and even bathrooms onboard. These can accommodate 9 passengers and can travel 2,000 miles in one direction. These are among the most common planes used for business purposes regarding executives and critical meetings.</p>
                            </div>
                        </div>
                        <div class="row align-items-center pt-4 pb-4">
                            <div class="col-5 offset-1">
                                <ul class="plane-list">
                                    <li><p>Citation Excel</p></li>
                                    <li><p>Citation III</p></li>
                                    <li><p>Citation VI</p></li>
                                    <li><p>Citation VII</p></li>
                                    <li><p>Citation XLS</p></li>
                                    <li><p>Citation XLS+</p></li>
                                    <li><p>G-100</p></li>
                                    <li><p>G-150</p></li>
                                    <li><p>Hawker 700A</p></li>
                                    <li><p>Hawker 800</p></li>
                                    <li><p>Hawker 800XP</p></li>
                                    <li><p>Hawker 900XP</p></li>
                                    <li><p>Learjet 60</p></li>
                                </ul>
                            </div>
                            <div class="col-5">
                                <img src="/images/plane.jpg" class="plane-img" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="light-jets" role="tabpanel" aria-labelledby="light-jets-tab">
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 plane-tab">Light Jets</p>
                                <p class="mb-0">The Light Jet class is often the smallest used for business purposes, but can often fit up to 6 passengers at once. These planes will come standard with luxurious seats that can recline as well as temperature and humidity control onboard. These are often used for short-range trips of 1,000 miles, or two hours. These limitations might be able to be greatly lengthened depending on the number of passengers or weight of what you’ll be bringing along  the ride.</p>
                            </div>
                        </div>
                        <div class="row align-items-center pt-4 pb-4">
                            <div class="col-5 offset-1">
                                <ul class="plane-list">
                                    <li><p>Beechjet 400</p></li>
                                    <li><p>Citation Bravo</p></li>
                                    <li><p>Citation CJ1</p></li>
                                    <li><p>Citation CJ1+</p></li>
                                    <li><p>Citation CJ2</p></li>
                                    <li><p>Citation CJ2+</p></li>
                                    <li><p>Citation CJ3</p></li>
                                    <li><p>Citation CJ4</p></li>
                                    <li><p>Citation Encore</p></li>
                                    <li><p>Citation Encore+</p></li>
                                    <li><p>Citation I / ISP</p></li>
                                    <li><p>Citation II / IISP</p></li>
                                    <li><p>Citation Jet</p></li>
                                    <li><p>Citation M2</p></li>
                                    <li><p>Citation Mustang</p></li>
                                    <li><p>Citation S/II</p></li>
                                    <li><p>Citation Ultra</p></li>
                                    <li><p>Citation V</p></li>
                                    <li><p>Hawker 400XP</p></li>
                                    <li><p>Honda Jet</p></li>
                                    <li><p>Learjet 35A</p></li>
                                    <li><p>Learjet 40/XR</p></li>
                                    <li><p>Learjet 45/XR</p></li>
                                    <li><p>Learjet 55</p></li>
                                    <li><p>Phenom 300</p></li>
                                    <li><p>Premier I</p></li>
                                </ul>
                            </div>
                            <div class="col-5">
                                <img src="/images/plane.jpg" class="plane-img" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="entry-level-jet" role="tabpanel" aria-labelledby="entry-level-jet-tab">
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 plane-tab">Entry-level Jet</p>
                                <p class="mb-0">This class of jet is slightly larger than the Turboprop and is the smallest plane class without propellers. This plane can still access small runways as well as major airports. The carrying capacity can range from 4-5 passengers and are equipped with some amenities. The most common limitation on this class is the carrying capacity of 10,000 pounds, however, these flights can travel 750 miles in one direction.</p>
                            </div>
                        </div>
                        <div class="row align-items-center pt-4 pb-4">
                            <div class="col-5 offset-1">
                                <ul class="plane-list">
                                    <li><p>Citation CJ1</p></li>
                                    <li><p>Citation M2</p></li>
                                    <li><p>Citation Mustang</p></li>
                                    <li><p>Mustang</p></li>
                                </ul>
                            </div>
                            <div class="col-5">
                                <img src="/images/plane.jpg" class="plane-img" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="turbopop" role="tabpanel" aria-labelledby="turbopop-tab">
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 plane-tab">Turbopop</p>
                                <p class="mb-0">Turboprops are the smallest class of jets and they are the most efficient plane for low altitude flights and typically operate below 450 mph. They are the most cost-efficient option and are often used for flights with an approximate duration of two hours and can land at both short runways as well as major airports.</p>
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
                                <img src="/images/plane.jpg" class="plane-img" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
        <div class="row">
            <div class="col">
                <p class="mb-0 plane-category">VIP airliner</p>
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-5 offset-1">
                <ul class="list-unstyled plane-list">
                    <li><p>Airbus 319</p></li>
                    <li><p>Boeing 373-500</p></li>
                    <li><p>Dornier 328</p></li>
                    <li><p>Lineage 1000</p></li>
                    <li><p>Boeing BBJ</p></li>
                    <li><p>Airbus ACJ</p></li>
                </ul>
            </div>
            <div class="col-4 offset-1">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/images/plane.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="/images/plane2.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>-->
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