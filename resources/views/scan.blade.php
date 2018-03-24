@extends('layouts.app')

@section('title', 'Scan Fob')

@section('content')
    <div class="card">
        <h3 class="card-header">Scan Fob</h3>
        <scanner v-bind:prompt-clone="promptClone" v-bind:add-message="addMessage" />
    </div>

    <div class="text-center mt-4">
	@if ($updateable)
	    Update Available!<br /><a href="/update" class="btn btn-warning btn-sm">Perform Update</a>
	@else
	    Last Check For Update: {{ $last_update_check }}
	@endif
    </div>
@endsection
