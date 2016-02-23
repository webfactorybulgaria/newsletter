{!! Honeypot::generate('my_name', 'my_time') !!}
{!! BootForm::hidden('id') !!}

{!! BootForm::email('<span class="fa fa-asterisk"></span> ' . trans('validation.attributes.email'), 'email') !!}

<div class="form-group">
    <span class="fa fa-asterisk"></span> @lang('global.Mandatory fields')
</div>
