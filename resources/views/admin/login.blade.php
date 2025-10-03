<x-guest-layout>
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url('{{ asset('assets/images/big/auth-bg.jpg') }}') no-repeat center center;">
        <div class="auth-box">
            <div class="logo text-center">
                <span class="db">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-10 h-auto mx-auto block"/>
                </span>
                <h5 class="font-bold text-lg text-gray-800 mb-3 mt-1">Sign In to Admin</h5>
            </div>

            <form method="POST" action="{{ url('admin/login') }}" class="form-horizontal m-t-20">
                @csrf

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

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                    </div>
                    <input id="password" type="password" name="password"
                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                           required autocomplete="current-password" placeholder="Password">
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-danger mb-2" />

                <div class="form-group text-center">
                    <div class="col-xs-12 p-b-20">
                        <button class="btn btn-block btn-lg btn-info" type="submit">Log In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

