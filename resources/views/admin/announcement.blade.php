<x-admin-layout>
    <div class="min-h-screen">
        <?php
        $textColorclass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black';
        $bgColorclass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white';
        $colors = ['red', 'yellow', 'green', 'blue'];
        ?>
        <h1 class="text-4xl font-bold mb-6 text-{{ $textColorclass }}">
            Announcement Settings
        </h1>
        <form method="POST" action="{{ route('admin.announcement.update') }}"
            class="w-full p-6 rounded-lg shadow-md bg-{{ $bgColorclass }}">
            @csrf
            @foreach ($groupedSettings as $group => $groupSettings)
                @if ($group === 'announcements')
                    @foreach ($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}"
                                class="block text-lg font-semibold text-{{ $textColorclass }}">{{ $setting->name }}</label>
                            @if (in_array($setting->name, ['user_color', 'guest_color']))
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $bgColorclass }} text-{{ $textColorclass }} focus:outline-none focus:border-blue-500 text-lg">
                                    @foreach ($colors as $color)
                                        <option value="{{ $color }}"
                                            @if ($setting->payload === $color) selected @endif>
                                             {{ ucfirst($color) }}{{--uc is used just for upeercase first letter --}}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}"
                                    value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $bgColorclass }} text-{{ $textColorclass }} focus:outline-none focus:border-blue-500 text-lg"
                                    required>
                            @endif
                        </div>
                    @endforeach
                @endif
            @endforeach
            <button type="submit"
                class="bg-{{ $textColorclass }} text-{{ $bgColorclass }} px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue text-lg">Save
                Changes</button>
        </form>
    </div>
</x-admin-layout>
