@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))

@section('action')
    <a href="{{ route('home') }}" class="btn btn-outline btn-primary">
        <i class="bi-chevron-left mr-2"></i>
        Back to Home
    </a>
@endsection
