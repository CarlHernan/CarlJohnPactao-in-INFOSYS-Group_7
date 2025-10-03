<x-guest-layout>
    <div class="container py-10">
        <h1 class="text-2xl font-semibold mb-4">Confirm Password</h1>
        <p class="mb-6 text-gray-600">Please confirm your password to continue.</p>
        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf
            <div>
                <label for="password" class="block text-sm font-medium">Password</label>
                <input id="password" name="password" type="password" required class="form-control" autocomplete="current-password">
                <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
            </div>
            <button type="submit" class="btn btn-info">Confirm</button>
        </form>
    </div>
</x-guest-layout>
<x-guest-layout>
    <div class="container py-10">
        <h1 class="text-2xl font-semibold mb-4">Forgot Password</h1>
        <p class="mb-6 text-gray-600">Enter your email and we'll send you a password reset link.</p>
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" required class="form-control" value="{{ old('email') }}">
                <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
            </div>
            <button type="submit" class="btn btn-info">Send Reset Link</button>
        </form>
    </div>
</x-guest-layout>

