@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))

@section('action')
    <a href="{{ route('home') }}" class="btn btn-outline btn-primary">
        <i class="bi-chevron-left mr-2"></i>
        Back to Home
    </a>
@endsection
