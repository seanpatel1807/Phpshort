<x-admin-layout>
    <div class="container mx-auto p-8 bg-gray-200 shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-black">New Page</h1>

        <form action="{{ route('pages.store') }}" method="post" class="max-w-md mx-auto">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm mb-2">Name</label>
                <input type="text" name="name" id="name" class="p-3 border border-gray-300 rounded w-full">
                @error('name')
                    <p class="text-sm error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-gray-700 text-sm mb-2">Slug</label>
                <input type="text" name="slug" id="slug" class="p-3 border border-gray-300 rounded w-full">
                @error('slug')
                    <p class="text-sm error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="visibility" class="block text-gray-700 text-sm mb-2">Visibility</label>
                <select name="visibility" id="visibility" required class="p-3 border border-gray-300 rounded w-full">
                    <option value="unlisted">Unlisted</option>
                    <option value="footer">Footer</option>
                </select>
                @error('visibility')
                    <p class="text-sm error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm mb-2">Content</label>
                <input type="text" name="content" id="content" class="p-3 border border-gray-300 rounded w-full">
                @error('content')
                    <p class="text-sm error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="bg-black text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
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
