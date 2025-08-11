<x-guest-layout>
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-2xl dark:bg-gray-800">

        <!-- Judul -->
        <div class="mb-5 sm:mb-8 text-center">
            <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                Forgot Password
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                No problem. Enter your email and we’ll send you a link to reset your password.
            </p>
        </div>

        <!-- Status Session -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Email<span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="you@example.com"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Send Reset Link
            </button>
        </form>

        <!-- Link Back to Login -->
        <p class="mt-6 text-sm text-center text-gray-600 dark:text-gray-400">
            Remember your password?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline dark:text-indigo-400">Sign In</a>
        </p>
    </div>
</x-guest-layout>
