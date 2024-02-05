<x-admin-layout>
    <div class="min-h-screen">
        <h1
            class="text-4xl font-bold mb-6 text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }}">
            Announcement Settings
        </h1>
        <form method="POST" action="{{ route('admin.announcement.update') }}"
            class="w-full p-6 rounded-lg shadow-md bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }}">
            @csrf
            @foreach ($groupedSettings as $group => $groupSettings)
                @if ($group === 'announcements')
                    @foreach ($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}"
                                class="block text-lg font-semibold text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }}">{{ $setting->name }}</label>
                            @if (in_array($setting->name, ['user_color', 'guest_color']))
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} focus:outline-none focus:border-blue-500 text-lg">
                                    <option value="red" @if ($setting->payload === 'red') selected @endif>Red
                                    </option>
                                    <option value="yellow" @if ($setting->payload === 'yellow') selected @endif>Yellow
                                    </option>
                                    <option value="green" @if ($setting->payload === 'green') selected @endif>Green
                                    </option>
                                    <option value="danger" @if ($setting->payload === 'danger') selected @endif>Blue
                                    </option>
                                </select>
                            @else
                                <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}"
                                    value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} focus:outline-none focus:border-blue-500 text-lg"
                                    required>
                            @endif
                        </div>
                    @endforeach
                @endif
            @endforeach
            <button type="submit"
                class="bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue text-lg">Save
                Changes</button>
        </form>
    </div>
</x-admin-layout>
