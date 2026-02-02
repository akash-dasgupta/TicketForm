<x-layout>
<div>
    <!-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius -->
       <h1 class="text-3xl text-center font-bold underline centered m-4">Staff Registration</h1>
        <form method="POST" action="{{ route('staff.register') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="Name">
                Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>

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

            <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                Confirm Password
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <div class="flex items-center justify-between">
            <button class="bg-green-600 text-white rounded hover:bg-blue-700 cursor-pointer font-bold py-2 px-4 focus:outline-none focus:shadow-outline" type="submit">
                Register
            </button>
            </div>
            <div>
            @if($errors->any())
                <div class="mt-4 text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="px-4 py-2 bg-red-100">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
        </form>

        <div class="flex text-center justify-between">
            <button class="bg-green-600 text-white rounded hover:bg-blue-700 cursor-pointer font-bold py-2 px-4 focus:outline-none focus:shadow-outline" onclick="window.location.href='{{ route('login') }}'">
                Login
            </button>
        </div>
</div>
</x-layout>
