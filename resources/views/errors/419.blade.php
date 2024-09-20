@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('The page has expired, please try again'))

@section('action')
    <a href="{{ url()->previous() }}" class="btn btn-outline btn-primary">
        <i class="bi-chevron-left mr-2"></i>
        Try again
    </a>
@endsection
