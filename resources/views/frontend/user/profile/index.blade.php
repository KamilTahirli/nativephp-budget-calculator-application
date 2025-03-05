@extends('frontend.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xl-4">
                            <div class="page-title-content">
                                <h3>@lang('site.user.edit_profile')</h3>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="breadcrumbs">
                                <a href="{{ route('home') }}">@lang('site.user.home')</a>
                                <span>
                                    <i class="fi fi-rr-angle-small-right"></i>
                                </span>
                                <span>@lang('site.user.edit_profile')</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12 col-xl-12">

                <div class="row equal-height-cards">
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update', $user->id) }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-xxl-12 col-12 mb-3">
                                            <label class="form-label">@lang('site.auth.name')</label>
                                            <input type="text"
                                                   name="name"
                                                   class="form-control"
                                                   value="{{ old('name', $user->name) }}">
                                            @error('name')
                                            <div class="error-msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xxl-12 col-12 mb-3">
                                            <label class="form-label">@lang('site.auth.email')</label>
                                            <input type="email"
                                                   class="form-control"
                                                   value="{{ $user->name }}" readonly disabled>
                                            @error('name')
                                            <div class="error-msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xxl-12 col-12 mb-3">
                                            <div class="d-flex align-items-center">
                                                <img
                                                    class="me-3 rounded-circle me-0 me-sm-3"
                                                    src="{{ asset($user->photo ? 'storage/profile/' . $user->photo : 'assets/frontend/images/avatar/no_photo.webp' ) }}"
                                                    width="55" height="55"
                                                    alt="">
                                                <div class="media-body">
                                                    <h4 class="mb-0">{{ $user->name }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-12 mb-3">
                                            <div class="form-file">
                                                <input type="file" name="photo" class="form-file-input" id="customFile">
                                                @error('photo')
                                                <div class="error-msg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-12 mb-3">
                                            <button type="submit"
                                                    class="btn btn-success">@lang('site.user.save')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.password.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">@lang('site.user.old_password')</label>
                                            <input type="password" name="old_password" class="form-control">
                                            @error('old_password')
                                            <div class="error-msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">@lang('site.user.new_password')</label>
                                            <input type="password" name="new_password" class="form-control">
                                            @error('new_password')
                                            <div class="error-msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">@lang('site.user.confirm_new_password')</label>
                                            <input type="password" name="confirm_password" class="form-control">
                                            @error('confirm_password')
                                            <div class="error-msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-12 mb-3">
                                            <button class="btn btn-success">@lang('site.user.save')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
