@extends('core::admin.master')

@section('title', trans('news::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <a href="{{ route('admin::create-newsletter') }}" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only">New</span></a>
    <h1>
        <span>@{{ models.length }} @choice('newsletter::global.newsletter', 2)</span>
    </h1>

    <a href="/admin/newsletter/export">Export list as cvs</a>

    <div class="table-responsive">

        <table st-persist="newsletterTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="email" class="email st-sort">Email</th>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input st-search="email" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model, model.title + ' ' + model.first_name + ' ' + model.last_name)"></td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'newsletter'])
                    </td>
                    <td>@{{ model.email }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
