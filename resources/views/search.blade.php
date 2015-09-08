@extends('layouts.master')

@section('title', 'Search')

@section('content')
    <div class="page-header">
        <h1>Search {!! $query ? "for: <span class='text-muted'>$query</span>" : "" !!}</h1>
        @if($query)
            <p>total {{ $repositories['total_count'] }} repo found, showing {{ count($repositories['items']) }} items</p>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="custom-search-input">
                <form action="/search" method="get" accept-charset="utf-8" role="form">
                    <div class="input-group col-md-12">
                        <input type="text" name="q" value="{{ $query }}" class="form-control input-lg" placeholder="Search in repos..." />
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($repositories)
        <hr>

        <div class="list-group">
            @foreach($repositories['items'] as $repo)
                <a href="{{ $repo['url'] }}" target="_blank" class="list-group-item">
                    <h4 class="list-group-item-heading">{{ $repo['name'] }}</h4>
                    <p class="list-group-item-text">{{ $repo['description'] }}</p>
                </a>
            @endforeach
        </div>

        <nav>
            {!! $pagination->render() !!}
        </nav>
    @endif

@endsection