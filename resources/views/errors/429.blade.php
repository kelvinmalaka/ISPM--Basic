@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))

@section('action')
    <a href="{{ route('home') }}" class="btn btn-outline btn-primary">
        <i class="bi-chevron-left mr-2"></i>
        Back to Home
    </a>
@endsection
