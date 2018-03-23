@extends('layouts.app')

@section('title', 'History')

@section('content')
    <div class="card">
        <h3 class="card-header">History</h3>
        <history v-bind:prompt-clone="promptClone" />
    </div>
@endsection