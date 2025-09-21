<x-guest-layout>
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" 
         style="background:url('{{ asset('assets/images/big/auth-bg.jpg') }}') no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo text-center">
                    <span class="db">
                        <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-10 h-auto mx-auto block "/>
                    </span>
                    <h5 class="font-bold text-lg text-gray-800 mb-3 mt-1">Sign In to Admin</h5>
                </div>

                <!-- Breeze Login Form -->
                <form method="POST" action="{{ route('login') }}" class="form-horizontal m-t-20">
                    @csrf

                    <!-- Email -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                        </div>
                        <input id="email" type="email" name="email"
                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus autocomplete="username"
                               placeholder="Email">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="text-danger mb-2" />

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                        </div>
                        <input id="password" type="password" name="password"
                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                               required autocomplete="current-password" placeholder="Password">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-danger mb-2" />

                    <!-- Remember + Forgot -->
                    <div class="form-group row">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                                <label class="custom-control-label" for="remember_me">Remember me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-dark">
                                    <i class="fa fa-lock m-r-5"></i> Forgot pwd?
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="form-group text-center">
                        <div class="col-xs-12 p-b-20">
                            <button class="btn btn-block btn-lg btn-info" type="submit">Log In</button>
                        </div>
                    </div>

                    <!-- Social Login (Optional) -->
                    <div class="row">
                        <div class="col-12 text-center m-t-10">
                            <div class="social">
                                <a href="#" class="btn btn-facebook" title="Login with Facebook">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#" class="btn btn-googleplus" title="Login with Google">
                                    <i class="fab fa-google-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Sign Up -->
                    <div class="form-group m-b-0 m-t-10">
                        <div class="col-sm-12 text-center">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-info m-l-5"><b>Sign Up</b></a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Recover Password Form -->
            <div id="recoverform" style="display: none;">
                <div class="logo text-center">
                    <span class="db">
                        <img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo" />
                    </span>
                    <h5 class="font-medium m-b-20">Recover Password</h5>
                    <span>Enter your Email and instructions will be sent to you!</span>
                </div>
                <div class="row m-t-20">
                    <form class="col-12" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-12">
                                <input id="recover_email" class="form-control form-control-lg" 
                                       type="email" name="email" required placeholder="Email">
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-block btn-lg btn-danger" type="submit">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
