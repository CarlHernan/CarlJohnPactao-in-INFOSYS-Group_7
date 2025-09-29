<x-guest-layout>
    <div class="container py-10">
        <h1 class="text-2xl font-semibold mb-4">Reset Password</h1>
        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ request('token') }}">

            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" required class="form-control" value="{{ old('email', request('email')) }}">
                <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium">New Password</label>
                <input id="password" name="password" type="password" required class="form-control">
                <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="form-control">
            </div>

            <button type="submit" class="btn btn-info">Reset Password</button>
        </form>
    </div>
</x-guest-layout>

