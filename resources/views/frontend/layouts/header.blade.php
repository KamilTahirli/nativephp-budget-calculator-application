<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <div class="header-content">
                    <div class="header-left">
                        <div class="brand-logo">
                            <a class="mini-logo" href="#">
                                <img src="#" alt="" width="40">
                            </a>
                        </div>
                    </div>
                    <div class="header-right">
                        <div class="dark-light-toggle" onclick="themeToggle()">
                            <span class="dark"><i class="fi fi-rr-eclipse-alt"></i></span>
                            <span class="light"><i class="fi fi-rr-eclipse-alt"></i></span>
                        </div>

                        @auth
                            <div class="dropdown profile_log dropdown">
                                <div data-bs-toggle="dropdown">
                                    <div class="user icon-menu active"><span><i class="fi fi-rr-user"></i></span></div>
                                </div>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                     class="dropdown-menu dropdown-menu dropdown-menu-end">
                                    <div class="user-email">
                                        <div class="user">
                                        <span class="thumb">
                                            <img class="rounded-full"
                                                 width="40"
                                                 height="40"
                                                 src="{{ asset(auth()->user()->photo ? 'storage/profile/'. auth()->user()->photo : 'assets/frontend/images/avatar/no_photo.webp') }}" alt="">
                                        </span>
                                            <div class="user-info">
                                                <h5>{{ auth()->user()->name }}</h5>
                                                <span>{{ auth()->user()->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="{{ route('profile.index', auth()->user()->id) }}">
                                        <span><i class="fi fi-rr-user"></i></span>
                                        @lang('site.user.profile')
                                    </a>
                                    <a class="dropdown-item logout" href="{{ route('logout') }}">
                                        <span><i class="fi fi-bs-sign-out-alt"></i></span>
                                        @lang('site.auth.logout')
                                    </a>
                                </div>
                            </div>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
