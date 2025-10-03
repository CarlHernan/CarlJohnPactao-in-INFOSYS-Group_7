<x-guest-layout>
    <div class="container py-10">
        <h1 class="text-2xl font-semibold mb-4">Verify Your Email</h1>
        <p class="mb-6 text-gray-600">Please verify your email address by clicking the link we sent to your inbox.</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-info">Resend Verification Email</button>
        </form>
    </div>
</x-guest-layout>

