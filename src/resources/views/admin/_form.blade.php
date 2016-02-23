@include('core::admin._buttons-form')

@include('newsletter::_fields')

{!! BootForm::hidden('my_time')->value(Crypt::encrypt(time()-60)) !!}
