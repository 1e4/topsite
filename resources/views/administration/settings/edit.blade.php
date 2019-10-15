@extends('layouts.admin')

@section('content')


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Settings</h1>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">General Settings</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('settings.update')->put() !!}
            {!! \Form::text('discord_webhook', 'Discord Webhook', $settings->where('key', 'discord_webhook')->first()->value) !!}
            {!! \Form::checkbox('site_online', 'Site Online', 1, $settings->where('key', 'site_online')->first()->value === "1") !!}
            {!! Form::submit("Update Settings") !!}
            {!! \Form::close() !!}
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">SEO Settings</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('settings.seo.update')->put() !!}
            {!! \Form::text('seo_title', 'Site Name', $settings->where('key', 'seo_title')->first()->value) !!}
            {!! \Form::textarea('seo_description', 'Meta Description', $settings->where('key', 'seo_description')->first()->value) !!}
            {!! Form::submit("Update Settings") !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection
