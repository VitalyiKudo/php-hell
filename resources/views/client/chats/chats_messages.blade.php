@extends('client.chats.layouts.app')

@section('content')
<div class="container">
    <chats :current_user="{{ $user }}" :room_id="{{ $room_id }}"></chats>
</div>
@endsection
