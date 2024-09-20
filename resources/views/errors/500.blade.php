@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('We are sorry, a server error has occured'))

@section('action')
    <a href="{{ route('home') }}" class="btn btn-outline btn-primary">
        <i class="bi-chevron-left mr-2"></i>
        Back to Home
    </a>
@endsection
