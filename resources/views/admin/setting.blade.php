<x-admin-layout>
    <div class="min-h-screen">
        <?php
        $textColorclass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black';
        $bgColorclass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white';
        ?>
        <h1 class="text-4xl font-bold mb-6 text-{{ $textColorclass }}">
            General Settings
        </h1>
        <form method="POST" action="{{ route('admin.general.update') }}" class="w-full p-6 rounded-lg shadow-md"
            style="background-color: {{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? '#333333' : '#ffffff' }}">
            @csrf
            @foreach ($groupedSettings as $group => $groupSettings)
                @if ($group === 'general')
                    @foreach ($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}"
                                class="block text-lg font-semibold text-{{ $textColorclass }}">
                                {{ $setting->name }}
                            </label>

                            @if ($setting->name === 'language')
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $bgColorclass }} text-{{ $textColorclass }} focus:outline-none focus:border-blue-500 text-lg">
                                    <option value="english" @if ($setting->payload === 'english') selected @endif>English
                                    </option>
                                    <option value="hindi" @if ($setting->payload === 'hindi') selected @endif>Hindi
                                    </option>
                                </select>
                            @elseif($setting->name === 'timezone')
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $bgColorclass }} text-{{ $textColorclass }} focus:outline-none focus:border-blue-500 text-lg">
                                    <option value="utc" @if ($setting->payload === 'utc') selected @endif>UTC
                                    </option>
                                    <option value="pacific" @if ($setting->payload === 'pacific') selected @endif>Pacific
                                    </option>
                                </select>
                            @elseif($setting->name === 'results_per_page')
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}"
                                    class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $bgColorclass }} text-{{ $textColorclass }} focus:outline-none focus:border-blue-500 text-lg">
                                    <option value="10" @if ($setting->payload === '10') selected @endif>10</option>
                                    <option value="25" @if ($setting->payload === '25') selected @endif>25</option>
                                    <option value="50" @if ($setting->payload === '50') selected @endif>50
                                    </option>
                                    <option value="100" @if ($setting->payload === '100') selected @endif>100
                                    </option>
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
