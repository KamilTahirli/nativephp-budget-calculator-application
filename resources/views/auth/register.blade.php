@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">@lang('site.auth.register_title')</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row mt-3">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('site.auth.name')</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label for="email" class="col-md-4 col-form-label text-md-right">@lang('site.auth.email')</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label for="password" class="col-md-4 col-form-label text-md-right">@lang('site.auth.password')</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('site.auth.confirm_password')</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('site.auth.registerSubmit')
                                    </button>
                                </div>
                            </div>
                        </form>
                        <p class="mt-3 mb-0 text-center undefined">
                            @lang('site.auth.already_have_an_account')
                            <a class="text-primary" href="{{ route('login') }}">@lang('site.auth.login_title')</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

