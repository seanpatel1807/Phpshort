<x-admin-layout>
    <div class="container mx-auto p-8 bg-gray-200 shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-black">Edit User</h1>

        <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post" class="max-w-md mx-auto">
            @csrf
            @method('patch')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="p-3 border border-gray-300 rounded w-full">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="p-3 border border-gray-300 rounded w-full">
            </div>

            <button type="submit"
                class="bg-black text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                Update User
            </button>
        </form>
    </div>
</x-admin-layout>
