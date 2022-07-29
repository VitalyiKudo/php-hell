@extends('client.chats.layouts.app')

@section('content')
<div class="container">
    <chats :current_user="{{ $user }}" :room_id="{{ $room->id }}"></chats>
</div>
@endsection
