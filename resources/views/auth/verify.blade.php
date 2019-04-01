@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Подтвердите e-mail</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Ссылка для восстановления была отправлена на ваш адрес.
                        </div>
                    @endif

                        Перед тем как продолжить, пожалуйста проверьте вашу почту.
                    Если вы не получили письмо, <a href="{{ route('verification.resend') }}">нажмите сюда, чтобы отправить его повторно.</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
