@extends('layouts.master')

@section('title', 'My Repositories')

@section('content')
    <div class="page-header">
        <h1>Repositories</h1>
    </div>

    <div class="list-group">
        @foreach($repositories as $repo)
            <a href="{{ $repo['html_url'] }}" target="_blank" class="list-group-item">
                <h4 class="list-group-item-heading">{{ $repo['name'] }}</h4>
                <p class="list-group-item-text">{{ $repo['description'] }}</p>
            </a>
        @endforeach
    </div>

@endsection