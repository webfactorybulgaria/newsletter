@extends('core::admin.master')

@section('title', trans('newsletter::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'newsletter'])
    <h1>
        @lang('newsletter::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-newsletter'))->multipart()->role('form') !!}
        @include('newsletter::admin._form')
    {!! BootForm::close() !!}

@endsection
