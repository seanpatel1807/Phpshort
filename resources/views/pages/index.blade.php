<x-admin-layout>
    <div style="text-align: right; margin-bottom: 10px;">
        <a href="{{ route('pages.create') }}"
            style="display: inline-block; padding: 10px 20px; background-color: #7b60fb; color: #fff; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;"
            onmouseover="this.style.backgroundColor='#5e42eb'" onmouseout="this.style.backgroundColor='#7b60fb'">
            New
        </a>
    </div>
    <form action="{{ route('pages.index') }}" method="GET" class="mb-4">
        <input type="text" name="search" placeholder="Search users..." class="p-2 border rounded">
        <button type="submit" style="background-color: #7b60fb; color: white;"
            class="px-4 py-2 rounded">Search</button>
    </form>
    <div class="container mx-auto p-8">
        <h1 class="font-bold mb-6 text-gray-900" style="font-size: 30px">Pages</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-200 text-black text-lg" style="width: 100%">
                <thead>
                    <tr>
                        <th class="py-3 px-6">Name</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($page as $pages)
                        <tr>
                            <td class="py-4 px-6 text-center">{{ $pages->name }}</td>
                            <td class="py-4 px-6 text-center relative">
                                <div x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="inline-flex items-center justify-center w-6 h-6 text-gray-500 hover:text-gray-700 focus:outline-none">
                                        ...
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div x-show="open" @click.away="open = false"
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                        <div class="py-1">
                                            <form action="{{ route('pages.edit', $pages->id) }}" method="get"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                                    Edit
                                                </button>
                                            </form>
                                            <form action="{{ route('pages.destroy', $pages->id) }}" method="post"
                                                class="inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                    class="block w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-100 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-6 text-center">No pages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if (session('success'))
        <div id="success-alert" class="bg-gray-800 border-l-4  text-white px-4 py-3 rounded relative mb-4 shadow-md"
            role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <button id="close-alert" class="absolute top-0 right-0 px-3 py-1 focus:outline-none">
                <span>&times;</span>
            </button>
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('success-alert').style.opacity = '0';
                document.getElementById('success-alert').style.transition = 'opacity 0.5s';
                setTimeout(function() {
                    document.getElementById('success-alert').remove();
                }, 500);
            }, 5000);
        </script>
    @endif
</x-admin-layout>
