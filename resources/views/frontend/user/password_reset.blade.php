@extends('auth-layouts.auth')

@section('title', trans('default.forget_password'))

@section('contents')
    <div id="app">
        <password-reset :config-data="{{ json_encode(config('settings.application'))}}"></password-reset>
    </div>
@endsection
