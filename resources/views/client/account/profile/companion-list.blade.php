@extends('client.account.profile.layout')
@section('meta')
    <title>Companions | JetOnset</title>
@endsection

@section('profile-title')
    Companions
@endsection

@section('body')
    
        <div class="row">
            

            <div class="col-xl-12 col-lg-12">
                <h2 class="mb-5">Overview of your requests</h2>
                <div class="row names-block">
                    <div class="col-md-12 mb-4">
                        <div class="form-group names-list mb-2">
                            <div class="row">
                                <div class="col-auto">
                                <a href='{{ url("/profile/companions") }}' type="button" class="plus-btn">
                                        <img src="/images/plus2.png" class="icon-img" alt="...">
                                    </a> 
                                </div>
                            </div>
                        </div>              
                    </div>
                </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">

                                <div class="col-md-3 icao">
                                    <p> {{ $user->first_name }} </p>
                                </div>
                                <div class="col-md-2 icao">
                                    <p> {{ $user->last_name }} </p>
                                </div>
                                <div class="col-md-3 date text-center">
                                    {{ $user->email }}
                                </div>
                                <div class="col-md-4 book">
                                    <a href='{{ url("profile/user/$user->id/edit") }}' class="btn"><i class="fas fa-pencil-alt"></i></a>
                                    
                                    <a href='{{ url("profile/user/$user->id/delete") }}' class="btn ml-1"> 
                                    <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                <h5>COmpanion List</h5>
                @foreach ($companions as $request)

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">

                                <div class="col-md-3 icao">
                                    <p> {{ $request->first_name }} </p>
                                </div>
                                <div class="col-md-2 icao">
                                    <p> {{ $request->last_name }} </p>
                                </div>
                                <div class="col-md-3 date text-center">
                                    {{ $request->email }}
                                </div>
                                <div class="col-md-4 book">
                                    <a href='{{ url("profile/companion/$request->id/edit") }}' class="btn"><i class="fas fa-pencil-alt"></i></a>
                                    
                                    <a href='{{ url("profile/companion/$request->id/delete") }}' class="btn ml-1"> 
                                    <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                @endforeach

            </div>
        </div>
    

    
@endsection


