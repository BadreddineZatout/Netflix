@php
    $data = [
        'revendeur' => authorize_any(['view_info_revendeur']) && !$is_admin,
        'admin' => authorize_any(['view_info_admin']),
        'tables_admin' => authorize_any(['view_table_admin']),
    ]
@endphp

@extends('layouts.app')

@section('title', trans('Home'))

@section('contents')
    <dashboard-default :data="{{ json_encode($data) }}"></dashboard-default>
@endsection
