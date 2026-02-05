@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<dashboard-index user-name="{{ auth()->user()->name }}"></dashboard-index>
@endsection
