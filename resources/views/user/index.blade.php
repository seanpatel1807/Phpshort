<x-admin-layout>
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">User List</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-200 text-black text-lg" style="width: 100%">
                <thead>
                    <tr>
                        <th class="py-3 px-6">Name</th>
                        <th class="py-3 px-6">Email</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr x-data="{ open: false }">
                            <td class="py-4 px-6 text-center">{{ $user->name }}</td>
                            <td class="py-4 px-6 text-center">{{ $user->email }}</td>
                            <td class="py-4 px-6 text-center relative">
                                <div>
                                    <button type="button" @click="open = !open"
                                        class="inline-flex items-center justify-center w-6 h-6 text-gray-500 hover:text-gray-700 focus:outline-none">
                                        ...
                                    </button>
                                </div>

                                <!-- Dropdown menu -->
                                <div x-show="open" @click.away="open = false"
                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        <form action="{{ route('user.edit', ['user' => $user->id]) }}" method="get"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                                Edit
                                            </button>
                                        </form>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post"
                                            class="inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 hover:text-red-900">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-6 text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
