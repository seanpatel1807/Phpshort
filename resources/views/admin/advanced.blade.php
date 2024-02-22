<x-admin-layout>
    <div class="min-h-screen">
        <?php
        $textColorclass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black';
        $bgColorclass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white';
        ?>
        <h1 class="text-4xl font-bold mb-6 text-{{ $textColorclass }}">
            Advanced Settings
        </h1>
        <form method="POST" action="{{ route('admin.advanced.update') }}" class="w-full p-6 rounded-lg shadow-md"
            style="background-color: {{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? '#333333' : '#ffffff' }}">
            @csrf
            @foreach ($groupedSettings as $group => $groupSettings)
                @if ($group === 'advanced')
                    @foreach ($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}"
                                class="block text-lg font-semibold text-{{ $textColorclass }}">
                                {{ $setting->name }}
                            </label>

                            @if ($setting->name === 'user_agent')
                                <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}"
                                    value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $bgColorclass }} text-{{ $textColorclass }} focus:outline-none focus:border-blue-500 text-lg"
                                    required>
                            @else
                                <textarea type="text" id="{{ $setting->name }}" name="{{ $setting->name }}" value="{{ $setting->payload }}"
                                    placeholder="{{ $setting->payload }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $bgColorclass }} text-{{ $textColorclass }} focus:outline-none focus:border-blue-500 text-lg"
                                    required></textarea>
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
