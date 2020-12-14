@php
    $data = [
        'user' => Auth::user(),
        'permission' => authorize_any(['view_default','view_pannes','view_transactions','view_abonnements','view_revendeur','view_parametrage']),
    ]
@endphp

@extends('layouts.app')

@section('title', trans('Home'))

@section('contents')
    <dashboard-default :data="{{ json_encode($data) }}"></dashboard-default>
@endsection
