<x-layout>
    <div>
    <!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->
        <h1 class="text-3xl text-center font-bold underline centered m-4">Staff Login</h1>
        <form method="POST" action="{{ route('staff.login') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" required>
            </div>
            <div class="flex items-center justify-between">
            <button class="bg-green-600 text-white rounded hover:bg-blue-700 cursor-pointer font-bold py-2 px-4 focus:outline-none focus:shadow-outline" type="submit">
                Login
            </button>
        </form>

        <div class="flex text-center justify-between">
            <button class="bg-green-600 text-white rounded hover:bg-blue-700 cursor-pointer font-bold py-2 px-4 focus:outline-none focus:shadow-outline" onclick="window.location.href='{{ route('view.register') }}'">
                Register
            </button>
    </div>
</x-layout>
