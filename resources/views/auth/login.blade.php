@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center d-flex justify-content-center">
                        @lang('site.auth.login_title')
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="email">@lang('site.auth.email')</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">@lang('site.auth.password')</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit"
                                    class="btn btn-primary btn-block">@lang('site.auth.loginSubmit')</button>
                        </form>
                        <p class="mt-3 mb-0 text-center undefined">
                            @lang('site.auth.dont_have_an_account')
                            <a class="text-primary" href="{{ route('register') }}">@lang('site.auth.register_title')</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
