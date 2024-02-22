<x-app-layout>
    <div class="max-w-2xl mx-auto mt-6 p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Create a New Space</h2>

        <form method="POST" action="{{ route('store') }}" id="valueForm">
            @csrf

            <div class="mb-4">
                <label for="value" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" id="value" name="value" required
                    class="w-full border rounded-md py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    style="background-color: #7b60fb;color:white">
                    Save
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
