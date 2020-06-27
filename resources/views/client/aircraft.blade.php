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
                <p class="mb-5">With JetOnset you have access to <strong> thousands of planes</strong> positioned across the world, all accessible at your own fingertips. Take a journey through the wide variety of classes and options we can bring to you, at a fraction of the cost. These range from small propeller driven planes to VIP Airliners designed for professional Sports Teams and celebrities. </p>
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
                        <a class="nav-link active active-link" id="vip-airliner-tab" data-toggle="tab" href="#vip-airliner" role="tab" aria-controls="vip-airliner" aria-selected="true">VIP airliner</a>
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
                    <li class="nav-item turbopop">
                        <a class="nav-link last-nav-link" id="turbopop-tab" data-toggle="tab" href="#turbopop" role="tab" aria-controls="turbopop" aria-selected="false">Turbo Prop</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container sec-size">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active tab-click" id="vip-airliner" role="tabpanel" aria-labelledby="vip-airliner-tab">
                <div class="row">
                    <div class="col-md-12 bg-plane">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-r">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner car-padding">
                                <div class="carousel-item active">
                                    <img class="d-block img-style" src="/images/aircrafts/jet_types_8.png" alt="First slide">
                                    <div class="carousel-caption air-pole">
                                        <p class="plane-tab">VIP Airliner</p>
                                        <p class="mb-0 plane-tab-2">There are many good reasons why this class is called VIP Airliner, and that’s because they truly live up to their name. These jets have been designed for VIP’s from the ground up. Featuring a private bedroom, customized styling for all interiors, these planes are often used by Sports Teams and celebrities alike. 
                                            <span class="extra_text">They can take you and your company anywhere you need to go, with a carrying capacity of over 100 passengers. They can travel 7,500 miles, unlocking limitless destinations for your next corporate retreat or your next concert hall. These are the crown jewels of the Airbus and Boeing Aircraft lines, and are truly something to behold.</span>
                                        </p>
                                        <div class="rd-more-section">
                                            <a class="read-more">Read More</a>
                                        </div>
                                        
                                        
                                        <table class="plane-details">
                                            <tr>
                                                <td class="table-portion txt1">
                                                    <span class='main-text'> 20+</span>
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>17-<span class='main-text2'>936</span> 
                                                    </span>  
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>4-<span class='main-text2'>10h</span>
                                                    </span>
                                                 </td>
                                                <td class="table-portion2 txt2"> 
                                                    <span class='main-text'>6000<span class='main-text2'>nm</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="txt1"><span class='sub-text'>Passengers</span> </td>
                                                <td class="txt3"><span class='sub-text'>Max Bags</span></td>
                                                <td class="txt3"><span class='sub-text'>Flights</span></td>
                                                <td class="txt2"><span class='sub-text'>Max Range</span></td>
                                            </tr>
                                        </table>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> VIP Airliner  </span> 
                        <span class="flight-header2"> fleet  </span> 
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm">
                                    <p> Beechjet 400 </p>  
                                    <p> Citation Bravo </p>  
                                    <p> Citation CJ1 </p>  
                                    <p> Citation CJ1+</p>
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
                <div class="row">
                    <div class="col-md-12 bg-plane" >
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-r">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner car-padding">
                                <div class="carousel-item active">
                                    <img class="d-block img-style" src="/images/aircrafts/jet_types_7.png" alt="First slide">
                                    <div class="carousel-caption air-pole">
                                        <p class="mb-0 plane-tab">Ultra Long Range Jets</p>
                                        <p class="mb-0 plane-tab-2">These Ultra Long Range Jets are what you need if you are flying around the world. These are the most common types of jets used for flights that will last over 12 hours, and have a carrying capacity of up to 19 passengers. 
                                            <span class="extra_text">If your business or family is looking for a non-stop option to travel around the world, this is your safest bet. Coincidentally with the rise and popularity of private jet charters, these are the newest class of aircraft to join the marketplace.</span>
                                        </p>
                                        <div class="rd-more-section">
                                            <a class="read-more">Read More</a>
                                        </div>
                                        
                                        
                                        <table class="plane-details">
                                            <tr>
                                                <td class="table-portion txt1">
                                                    <span class='main-text'> 14+</span>
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>15-<span class='main-text2'>740</span> 
                                                    </span>  
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>6-<span class='main-text2'>14h</span>
                                                    </span>
                                                 </td>
                                                <td class="table-portion2 txt2"> 
                                                    <span class='main-text'>8500<span class='main-text2'>nm</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="txt1"><span class='sub-text'>Passengers</span> </td>
                                                <td class="txt3"><span class='sub-text'>Max Bags</span></td>
                                                <td class="txt3"><span class='sub-text'>Flights</span></td>
                                                <td class="txt2"><span class='sub-text'>Max Range</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Ultra Long Range Jets </span> 
                        <span class="flight-header2"> fleet  </span> 
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm">
                                   
                                    <p> Citation CJ1+</p>
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

            <div class="tab-pane fade tab-click" id="heavy-jets" role="tabpanel" aria-labelledby="heavy-jets-tab">
                <div class="row">
                    <div class="col-md-12 bg-plane2">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-r">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner car-padding">
                                <div class="carousel-item active">
                                    <img class="d-block img-style" src="/images/aircrafts/jet_types_6.png" alt="First slide">
                                    <div class="carousel-caption air-pole2">
                                    <p class="mb-0 plane-tab">Heavy Jets</p>
                                        <p class="mb-0 plane-tab-2">The Heavy Jets are getting closer in appearance to large commercial aircraft, and can hold a capacity of 18 passengers. These are complete with the luxurious amenities often found on commercial airliners as well as a potential 10 hour duration capacity of flight. 
                                        <span class="extra_text"> These are the most common planes used for intercontinental flights due to their 4,000 mile range and are a favorite among the elite.</span></p>
                                        <div class="rd-more-section">
                                            <a class="read-more">Read More</a>
                                        </div>
                                        
                                        
                                        <table class="plane-details">
                                            <tr>
                                                <td class="table-portion txt1">
                                                    <span class='main-text'> 12+</span>
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>8-<span class='main-text2'>33</span> 
                                                    </span>  
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>3-<span class='main-text2'>10h</span>
                                                    </span>
                                                 </td>
                                                <td class="table-portion2 txt2"> 
                                                    <span class='main-text'>4800<span class='main-text2'>nm</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="txt1"><span class='sub-text'>Passengers</span> </td>
                                                <td class="txt3"><span class='sub-text'>Max Bags</span></td>
                                                <td class="txt3"><span class='sub-text'>Flights</span></td>
                                                <td class="txt2"><span class='sub-text'>Max Range</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Heavy Jets </span> 
                        <span class="flight-header2"> fleet  </span> 
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm">
                                     <p> Citation Mustang</p>
                                    <p> Citation S / II</p>
                                    <p> Citation Ultra</p>
                                    <p> Citation V</p>
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

            <div class="tab-pane tab-click " id="super-mid-size-jets" role="tabpanel" aria-labelledby="super-mid-size-jets-tab">
                <div class="row">
                    <div class="col-md-12 bg-plane2">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-r">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner car-padding">
                                <div class="carousel-item active">
                                    <img class="d-block img-style" src="/images/aircrafts/jet_types_5.png" alt="First slide">
                                    <div class="carousel-caption air-pole2">
                                    <p class="mb-0 plane-tab">Super Midsize Jets</p>
                                    <p class="mb-0 plane-tab-2">The Super Midsize Jets are the Goldilocks of the businessman's private jet experience. Often referred to as the most effective in getting the best bang for your buck, these planes are equipped with the luxurious amenities often only found on larger commercial airliners but can accommodate 10 passengers.
                                    <span class="extra_text">These planes will have bathrooms and larger luggage capacity. The distance and the duration are also slightly better than the Midsize Jets with a range of up to 2,500 miles in one direction.</span></p>
                                        <div class="rd-more-section">
                                            <a class="read-more">Read More</a>
                                        </div>
                                        
                                        
                                        <table class="plane-details">
                                            <tr>
                                                <td class="table-portion txt1">
                                                    <span class='main-text'> 8+</span>
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>8-<span class='main-text2'>18</span> 
                                                    </span>  
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>2-<span class='main-text2'>6h</span>
                                                    </span>
                                                 </td>
                                                <td class="table-portion2 txt2"> 
                                                    <span class='main-text'>3600<span class='main-text2'>nm</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="txt1"><span class='sub-text'>Passengers</span> </td>
                                                <td class="txt3"><span class='sub-text'>Max Bags</span></td>
                                                <td class="txt3"><span class='sub-text'>Flights</span></td>
                                                <td class="txt2"><span class='sub-text'>Max Range</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Super Midsize Jets </span> 
                        <span class="flight-header2"> fleet  </span> 
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm">
                                     <p> Citation Mustang</p>
                                    <p> Citation S / II</p>
                                    <p> Citation Ultra</p>
                                    <p> Citation V</p>
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
                <div class="row">
                    <div class="col-md-12 bg-plane3">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-r">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner car-padding">
                                <div class="carousel-item active">
                                    <img class="d-block img-style" src="/images/aircrafts/jet_types_4.png" alt="First slide">
                                    <div class="carousel-caption air-pole2">
                                        <p class="mb-0 plane-tab">Midsize Jets</p>
                                        <p class="mb-0 plane-tab-2">These midsize jets are where things get interesting. These can travel up to 4 hours in one direction, and all models are equipped with luxuries and even bathrooms onboard. These can accommodate 9 passengers and can travel 2,000 miles in one direction.
                                        <span class="extra_text"> These are among the most common planes used for business purposes regarding executives and critical meetings.</span></p>
                                        <div class="rd-more-section">
                                            <a class="read-more">Read More</a>
                                        </div>
                                        
                                        
                                        <table class="plane-details">
                                            <tr>
                                                <td class="table-portion txt1">
                                                    <span class='main-text'> 7+</span>
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>6-<span class='main-text2'>11</span> 
                                                    </span>  
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>2-<span class='main-text2'>5h</span>
                                                    </span>
                                                 </td>
                                                <td class="table-portion2 txt2"> 
                                                    <span class='main-text'>3000<span class='main-text2'>nm</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="txt1"><span class='sub-text'>Passengers</span> </td>
                                                <td class="txt3"><span class='sub-text'>Max Bags</span></td>
                                                <td class="txt3"><span class='sub-text'>Flights</span></td>
                                                <td class="txt2"><span class='sub-text'>Max Range</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row txt-pos3">
                    <div class="col-md-12 plane-list">
                        <span class="flight-header"> Midsize Jets </span> 
                        <span class="flight-header2"> fleet  </span> 
                        <div class="section planes">
                        <div class="container">
                            <div class="row plane-listing">
                                <div class="col-sm">
                                    <p> Learjet 40 / XR</p>
                                    <p> Learjet 45 / XR</p>
                                    <p> Learjet 55</p>
                                    <p> Phenom 300</p>
                                    <p> Premier I</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane tab-click" id="light-jets" role="tabpanel" aria-labelledby="light-jets-tab">
                <div class="row">
                    <div class="col-md-12 bg-plane4">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-r">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner car-padding">
                                <div class="carousel-item active">
                                    <img class="d-block img-style2" src="/images/aircrafts/jet_types_3.png" alt="First slide">
                                    <div class="carousel-caption air-pole3">
                                        <p class="mb-0 plane-tab">Light Jets</p>
                                        <p class="mb-0 plane-tab-2">The Light Jet class is often the smallest used for business purposes, but can often fit up to 6 passengers at once. These planes will come standard with luxurious seats that can recline as well as temperature and humidity control onboard. These are often used for short-range trips of 1,000 miles, or two hours. 
                                        <span class="extra_text">These limitations might be able to be greatly lengthened depending on the number of passengers or weight of what you’ll be bringing along  the ride.</span></p>
                                        
                                        <div class="rd-more-section">
                                            <a class="read-more">Read More</a>
                                        </div>
                                        
                                        
                                        <table class="plane-details">
                                            <tr>
                                                <td class="table-portion txt1">
                                                    <span class='main-text'> 5+</span>
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>6-<span class='main-text2'>10</span> 
                                                    </span>  
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>1-<span class='main-text2'>3h</span>
                                                    </span>
                                                 </td>
                                                <td class="table-portion2 txt2"> 
                                                    <span class='main-text'>2300<span class='main-text2'>nm</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="txt1"><span class='sub-text'>Passengers</span> </td>
                                                <td class="txt3"><span class='sub-text'>Max Bags</span></td>
                                                <td class="txt3"><span class='sub-text'>Flights</span></td>
                                                <td class="txt2"><span class='sub-text'>Max Range</span></td>
                                            </tr>
                                        </table>
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
                                <div class="col-sm">
                                <p> Citation II / IISP</p>
                                    <p> Citation Jet</p>
                                    <p> Citation M2</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade tab-click" id="entry-level-jet" role="tabpanel" aria-labelledby="entry-level-jet-tab">
                <div class="row">
                    <div class="col-md-12 bg-plane4">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-r">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner car-padding">
                                <div class="carousel-item active">
                                    <img class="d-block img-style2" src="/images/aircrafts/jet_types_2.png" alt="First slide">
                                    <div class="carousel-caption air-pole3">
                                        <p class="mb-0 plane-tab">Entry-level Jet</p>
                                        <p class="mb-0 plane-tab-2">This class of jet is slightly larger than the Turboprop and is the smallest plane class without propellers. This plane can still access small runways as well as major airports. The carrying capacity can range from 4-5 passengers and are equipped with some amenities.
                                        <span class="extra_text"> The most common limitation on this class is the carrying capacity of 10,000 pounds, however, these flights can travel 750 miles in one direction.</span></p>
                                        
                                        <div class="rd-more-section">
                                            <a class="read-more">Read More</a>
                                        </div>
                                        
                                        
                                        <table class="plane-details">
                                            <tr>
                                                <td class="table-portion txt1">
                                                    <span class='main-text'> 4+</span>
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>5-<span class='main-text2'>8</span> 
                                                    </span>  
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>1-<span class='main-text2'>3h</span>
                                                    </span>
                                                 </td>
                                                <td class="table-portion2 txt2"> 
                                                    <span class='main-text'>1320<span class='main-text2'>nm</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="txt1"><span class='sub-text'>Passengers</span> </td>
                                                <td class="txt3"><span class='sub-text'>Max Bags</span></td>
                                                <td class="txt3"><span class='sub-text'>Flights</span></td>
                                                <td class="txt2"><span class='sub-text'>Max Range</span></td>
                                            </tr>
                                        </table>
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
                                <div class="col-sm">
                                    <p> Learjet 55</p>
                                    <p> Phenom 300</p>
                                    <p> Premier I</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>    

            <div class="tab-pane fade tab-click" id="turbopop" role="tabpanel" aria-labelledby="turbopop-tab">
                <div class="row">
                    <div class="col-md-12 bg-plane4">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-r">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner car-padding">
                                <div class="carousel-item active">
                                    <img class="d-block img-style2" src="/images/aircrafts/jet_types_1.png" alt="First slide">
                                    <div class="carousel-caption air-pole3">
                                        <p class="mb-0 plane-tab">Turbo prop</p>
                                        <p class="mb-0 plane-tab-2">Turboprops are the smallest class of jets and they are the most efficient plane for low altitude flights and typically operate below 450 mph.
                                        <span class="extra_text"> They are the most cost-efficient option and are often used for flights with an approximate duration of two hours and can land at both short runways as well as major airports.</span></p>
                                            
                                        <div class="rd-more-section">
                                            <a class="read-more">Read More</a>
                                        </div>
                                        
                                        
                                        <table class="plane-details">
                                            <tr>
                                                <td class="table-portion txt1">
                                                    <span class='main-text'> 6-19</span>
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>5-<span class='main-text2'>16</span> 
                                                    </span>  
                                                </td>
                                                <td class="table-portion txt3"> 
                                                    <span class='main-text'>1-<span class='main-text2'>3h</span>
                                                    </span>
                                                 </td>
                                                <td class="table-portion2 txt2"> 
                                                    <span class='main-text'>2260<span class='main-text2'>nm</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="txt1"><span class='sub-text'>Passengers</span> </td>
                                                <td class="txt3"><span class='sub-text'>Max Bags</span></td>
                                                <td class="txt3"><span class='sub-text'>Flights</span></td>
                                                <td class="txt2"><span class='sub-text'>Max Range</span></td>
                                            </tr>
                                        </table>
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
                                <div class="col-sm">
                                    <p> Learjet 40 / XR</p>
                                    <p> Learjet 45 / XR</p>
                                    <p> Learjet 55</p>
                                    <p> Phenom 300</p>
                                    <p> Premier I</p>
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
            <!-- <div class="tab-pane fade show active" id="vip-airliner" role="tabpanel" aria-labelledby="vip-airliner-tab">
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
            </div> -->
            <!-- <div class="tab-pane fade" id="ultra-long-range-jets" role="tabpanel" aria-labelledby="ultra-long-range-jets-tab">
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
            </div> -->
            <!-- <div class="tab-pane fade" id="heavy-jets" role="tabpanel" aria-labelledby="heavy-jets-tab">
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
            </div> -->
            <!-- <div class="tab-pane fade" id="super-mid-size-jets" role="tabpanel" aria-labelledby="super-mid-size-jets-tab">
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
            </div> -->
            <!-- <div class="tab-pane fade" id="mid-size-jets" role="tabpanel" aria-labelledby="mid-size-jets-tab">
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
            </div> -->
            <!-- <div class="tab-pane fade" id="light-jets" role="tabpanel" aria-labelledby="light-jets-tab">
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
            </div> -->
            <!-- <div class="tab-pane fade" id="entry-level-jet" role="tabpanel" aria-labelledby="entry-level-jet-tab">
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
            </div> -->
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
<!-- <div class="section planes">
    <div class="container">
        <div class="row plane-listing">
            <div class="col-sm">
                <p> Beechjet 400 </p>  
                <p> Citation Bravo </p>  
                <p> Citation CJ1 </p>  
                <p> Citation CJ1+</p>
                <p> Citation CJ2</p>
                <p> Citation CJ2+</p>
                <p> Citation CJ3</p>
            </div>
            <div class="col-sm">
                <p> Citation CJ4</p>
                <p> Citation Encore </p>
                <p> Citation Encore + </p>  
                <p> Citation I / ISP</p>
                <p> Citation II / IISP</p>
                <p> Citation Jet</p>
                <p> Citation M2</p>
            </div>
            <div class="col-sm">
                <p> Citation Mustang</p>
                <p> Citation S / II</p>
                <p> Citation Ultra</p>
                <p> Citation V</p>
                <p> Citation Hawker 400XP</p>
                <p> Honda Jet</p>
                <p> Learjet 35A</p>
            </div>
            <div class="col-sm">
                <p> Learjet 40 / XR</p>
                <p> Learjet 45 / XR</p>
                <p> Learjet 55</p>
                <p> Phenom 300</p>
                <p> Premier I</p>
            </div>
        </div>
    </div>
</div>     -->

<div class="section concierge">
    <div class="container">
        <div class="row">
            <div class="col-10 offset-1 col-lg-6 offset-lg-3">
                <div class="row align-items-center visit-card">
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
        $(document).ready(function(){
                
            $('.extra_text').hide();
            
            $('.read-mores').click(function(e){
                e.preventDefault();
                $('.extra_text').toggle();  
            });
            
        });
    </script>        
    
@endpush          