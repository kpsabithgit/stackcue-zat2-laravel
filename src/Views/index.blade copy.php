{{-- @php
    $viewFinder = app('view')->getFinder();
    dd([
        'paths' => $viewFinder->getPaths(),
        'viewName' => 'stackcue-zat2::layouts.app',
        'viewExists' => view()->exists('stackcue-zat2::layouts.app')
    ]);
@endphp --}}

@extends('stackcue-zat2::layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-3">Dashboard</h1>
        <!-- Your dashboard content goes here -->

        <div class="row">
            <!-- Add AdminKit's grid structure or other components here -->
        </div>
    </div>
@endsection
