@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('The page you are looking for is not found.'))

@section('action')
    <a href="{{ route('home') }}" class="btn btn-outline btn-primary">
        <i class="bi-chevron-left mr-2"></i>
        Back to Home
    </a>
@endsection
