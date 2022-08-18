@extends('client.chats.layouts.app')

@section('content')
<div class="container">
    <chat :current_user="{{ $user }}" :room_id="{{ $room->id }}"></chat>
</div>
@endsection
