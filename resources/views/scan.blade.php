@extends('layouts.app')

@section('title', 'Scan Fob')

@section('content')
    <div class="card">
        <h3 class="card-header">Scan Fob</h3>
        <scanner v-bind:prompt-clone="promptClone" v-bind:add-message="addMessage" />
    </div>

    @if ($updateable)
	<div class="text-center mt-4">
            Update Available!<br /><a href="/update" class="btn btn-warning btn-sm">Perform Update</a>
        </div>
    @endif
@endsection
