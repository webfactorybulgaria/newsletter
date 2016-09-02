@extends('core::admin.master')

@section('title', trans('news::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController" ng-show="!initializing">

    <a href="{{ route('admin::create-newsletter') }}" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only">New</span></a>
    <h1>
        <span>@{{ totalModels }} @choice('newsletter::global.newsletter', 2)</span>
    </h1>

    <a href="/admin/newsletter/export">Export list as cvs</a>

    <div class="table-responsive">

        <table st-persist="newsletterTable" st-table="displayedModels" st-order st-sort-default="email" st-pipe="callServer" st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <td colspan="3" st-items-by-page="itemsByPage" st-pagination="" st-template="/views/partials/pagination.custom.html"></td>
                </tr>
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

            <tbody ng-class="{'table-loading':isLoading}">
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
                    <td colspan="2" st-items-by-page="itemsByPage" st-pagination="" st-template="/views/partials/pagination.custom.html"></td>
                    <td>
                        <div ng-include="'/views/partials/pagination.itemsPerPage.html'"></div>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
