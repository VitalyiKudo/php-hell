@extends('admin.layouts.app')

@section('content')
        <div class="container" id="app" >
            <admin-chat :current_user="{{ $admin }}" :room_id="{{ $room->id }}"></admin-chat>
        </div>
@endsection
