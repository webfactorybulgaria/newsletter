@extends('pages::public.master')

@section('bodyClass', 'body-newsletter body-newsletter-sent body-page body-page-' . $page->id)

@section('main')

    {!! $page->body !!}

    <div class="jubotron alert alert-success text-center">
        <h1>@lang('db.message when newsletter form is sent')</h1>
    </div>

@stop
