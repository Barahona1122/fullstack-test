@extends('guest.layout.app')

@section('content')
	<div id="app">
	    <details-component slug="{{$slug}}"></details-component>
	</div>
@endsection