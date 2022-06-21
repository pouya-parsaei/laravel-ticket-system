@extends('layouts.layout')

@section('title' , __('auth.login user'))

@section('links')
    <script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer></script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('partials.alerts')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            @lang('auth.login')
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="email">@lang('auth.email')</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="email"
                                       value="{{old('email')}}"
                                       aria-describedby="emailHelp" placeholder="@lang('auth.enter your email')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="password">@lang('auth.password form')</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="@lang('auth.enter your password')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-check offset-sm-3">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                <label class="form-check-label" for="remember"><small>@lang('auth.remember me')</small></label>
                            </div>
                        </div>
                        <div class="offset-sm-3">
                            @include('partials.validation-errors')
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('auth.login')</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
