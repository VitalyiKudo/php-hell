@extends('admin.layouts.app')

@include('admin.chats.style')
@section('content')
        <div id="chat-app" class="chat-app-container">
            <chats :init-room-id="{{$room->id}}" :init-user="{{$admin}}"></chats>
        </div>
@endsection

@push('scripts')
    {{-- <script src="{{ (strtoupper(getenv('APP_ENV')) === 'LOCAL') ? asset('js/chatApp.js')  : mix('js/chatApp.min.js') }}"></script> --}}
    <script src="{{ asset('js/chatApp.min.js')}}"></script>
@endpush
