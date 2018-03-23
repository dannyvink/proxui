@extends('layouts.app')

@section('title', 'Scan Fob')

@section('content')
    <div class="card">
        <h3 class="card-header">Scan Fob</h3>
        <scanner v-bind:prompt-clone="promptClone" v-bind:add-message="addMessage" />
    </div>
@endsection