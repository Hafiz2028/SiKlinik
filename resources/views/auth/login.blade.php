<x-guest-layout>

    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-2xl dark:bg-gray-800">

        <!-- Judul -->
        <div class="mb-5 sm:mb-8">
            <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                Sign In
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Enter your Email and Password to Sign In!
            </p>
        </div>

        <!-- Status Session -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Email<span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="you@example.com"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Password<span class="text-red-500">*</span>
                </label>
                <div x-data="{ show: false }" class="relative">
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required
                        placeholder="••••••••"
                        class="mt-1 block w-full rounded-md border-gray-300 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                    <span @click="show = !show"
                        class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500 dark:text-gray-400">
                        👁
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900">
                    <span class="ml-2">Keep me logged in</span>
                </label>
                <a href="{{ route('password.request') }}"
                    class="text-sm text-indigo-600 hover:underline dark:text-indigo-400">
                    Forgot password?
                </a>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Sign In
            </button>
        </form>

        <!-- Link ke Register -->
        <p class="mt-6 text-sm text-center text-gray-600 dark:text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline dark:text-indigo-400">Sign Up</a>
        </p>
    </div>

</x-guest-layout>
