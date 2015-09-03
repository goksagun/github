@extends('layouts.master')

@section('title', 'Login GitHub Account')

@section('content')
    <div class="login-social">
        <a href="/auth/github" class="btn btn-block btn-social btn-twitter btn-lg">
            <i class="fa fa-github"></i> Sign in with GitHub
        </a>
    </div>
@endsection