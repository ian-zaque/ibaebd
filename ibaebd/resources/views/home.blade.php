@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                {{-- @guest --}}
                    <home-page></home-page>
                {{-- @else
                    <lista-manhaDivertida></lista-manhaDivertida>
                @endguest --}}
            </div>
        </div>
    </div>
@endsection
