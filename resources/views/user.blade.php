<!-- resources/views/users/index.blade.php -->

<x-admin-layout>
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">User List</h1>

        <form action="{{ route('users') }}" method="get" class="mb-4 flex justify-end">
            <div class="flex items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ $searchTerm }}"
                    placeholder="Search by name or email"
                    class="p-2 border border-gray-400 rounded"
                >
                <button
                    type="submit"
                    class="ml-2 bg-black text-white px-4 py-2 rounded"
                >
                    Search
                </button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-black text-white text-lg" style="width: 100%">
                <thead>
                    <tr>
                        <th class="py-3 px-6">Name</th>
                        <th class="py-3 px-6">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="py-4 px-6 text-center">{{ $user->name }}</td>
                            <td class="py-4 px-6 text-center">{{ $user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 px-6 text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
