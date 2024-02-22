<x-admin-layout>
    <div class="container mx-auto p-8 bg-gray-200 shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-black">New User</h1>

        <form action="{{ route('users.store') }}" method="post" class="max-w-md mx-auto">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm mb-2">Name</label>
                <input type="text" name="name" id="name" class="p-3 border border-gray-300 rounded w-full">
                @error('name')
                    <p class=" text-sm error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm mb-2">Email</label>
                <input type="email" name="email" id="email" class="p-3 border border-gray-300 rounded w-full">
                @error('email')
                    <p class=" text-sm error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm mb-2">Password</label>
                <input type="password" name="password" id="password" class="p-3 border border-gray-300 rounded w-full">
                @error('password')
                    <p class=" text-sm error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="p-3 border border-gray-300 rounded w-full">
                @error('password_confirmation')
                    <p class=" text-sm error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" style="background-color: #7b60fb;"
                class="text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                Save
            </button>

        </form>
    </div>
</x-admin-layout>

<style>
    .error-message {
        color: #ff0000;
        margin-top: 5px;
    }
</style>
