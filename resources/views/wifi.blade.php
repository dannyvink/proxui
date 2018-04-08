
@extends('layouts.app')

@section('title', 'Wi-Fi Settings')

@section('content')
    <div class="card">
        <h3 class="card-header">Wi-Fi Settings</h3>
        <wifi v-bind:add-message="addMessage" />
    </div>
@endsection