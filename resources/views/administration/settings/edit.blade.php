@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Settings</h1>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            {!! \Form::open()->route('settings.update')->put() !!}
            {!! \Form::text('site_name', 'Site Name', $settings->where('key', 'site_name')->first()->value) !!}
            {!! \Form::text('discord_webhook', 'Discord Webhook', $settings->where('key', 'discord_webhook')->first()->value) !!}
            {!! \Form::checkbox('site_online', 'Site Online', 1, $settings->where('key', 'site_online')->first()->value === "1") !!}
            {!! Form::submit("Update Settings") !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection
