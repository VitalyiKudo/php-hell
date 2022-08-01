@extends('client.chats.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">Rooms</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" style="min-height:300px;">
                        @foreach ($rooms as $room)
                            <li class="p-2" >
                                @if(Auth::guard('admin')->check())
                                    <a href="{{ url('chat/' . $room->id) }}"><strong>{{ $room->user->first_name . " " . $room->user->last_name . " " . $room->user->email . " (" . $room->messages->where('user_id', '!=', NULL)->where('saw', false)->count() . ")" }}</strong></a>
                                @elseif(Auth::guard('client')->check())
                                    <a href="{{ url('chat/' . $room->id) }}"><strong>{{ $room->user->first_name . " " . $room->user->last_name . " " . $room->user->email . " (" . $room->messages->where('administrator_id', '!=', NULL)->where('saw', false)->count() . ")" }}</strong></a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    {{ $rooms->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
