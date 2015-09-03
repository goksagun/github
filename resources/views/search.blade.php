@extends('layouts.master')

@section('title', 'Search')

@section('content')
    <div class="page-header">
        <h1>Search {{ $query ? "for: $query" : "" }}</h1>
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
            @foreach($repositories as $repo)
                <a href="{{ $repo['url'] }}" target="_blank" class="list-group-item">
                    <h4 class="list-group-item-heading">{{ $repo['name'] }}</h4>
                    <p class="list-group-item-text">{{ $repo['description'] }}</p>
                </a>
            @endforeach
        </div>

        <nav>
            <ul class="pagination">
                <li class="{{ $pagination['previous']['disabled'] ? 'disabled':'' }}"><a href="{{ $pagination['previous']['url'] }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                @foreach($pagination['links'] as $link)
                <li class="{{ $link['active'] ? 'active':'' }}"><a href="{{ $link['url'] }}">{{ $link['page'] }} {!! $link['active'] ? '<span class="sr-only">(current)</span>':'' !!}</a></li>
                @endforeach
                <li class="{{ $pagination['next']['disabled'] ? 'disabled':'' }}"><a href="{{ $pagination['next']['url'] }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>
        </nav>
    @endif

@endsection