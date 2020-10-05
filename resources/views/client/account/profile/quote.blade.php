@extends('client.account.profile.layout')
@section('meta')
<title>Account | JetOnset</title>
@endsection

@section('profile-title')
Account
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        
        
        {{ route('client.search.sendMail') }}
        
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Quotes</th>
                <th scope="col">Date</th>
                <th scope="col">Passengers</th>
              </tr>
            </thead>
            <tbody>
                @foreach($searches as $search)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $search->result_id }}</td>
                        <td>{{ Carbon\Carbon::parse($search->departure_at)->format('d.m.Y') }}</td>
                        <td>{{ $search->pax }}</td>
                    </tr>                   
                                            
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
@endsection
