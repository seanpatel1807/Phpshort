<x-admin-layout>
    <div class="bg-black min-h-screen" style="width: 180vh">
        <form method="POST" action="{{ route('admin.general.update') }}" class="w-full max-w-md p-6 rounded-lg shadow-md bg-gray-800">
            @csrf
            @foreach($groupedSettings as $group => $groupSettings)
                @if($group === 'general')
                    @foreach($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}" class="block text-lg font-semibold text-white">{{ $setting->name }}</label>

                            @if($setting->name === 'language')
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-700 text-black focus:outline-none focus:border-blue-500 text-lg">
                                    <option value="english" @if($setting->payload === 'english') selected @endif>English</option>
                                    <option value="hindi" @if($setting->payload === 'hindi') selected @endif>Hindi</option>
                                </select>
                            @elseif($setting->name === 'timezone')
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-700 text-black focus:outline-none focus:border-blue-500 text-lg">
                                    <option value="utc" @if($setting->payload === 'utc') selected @endif>UTC</option>
                                    <option value="pacific" @if($setting->payload === 'pacific') selected @endif>Pacific</option>
                                </select>
                            @elseif($setting->name === 'results_per_page')
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-700 text-black focus:outline-none focus:border-blue-500 text-lg">
                                    <option value="10" @if($setting->payload === '10') selected @endif>10</option>
                                    <option value="25" @if($setting->payload === '25') selected @endif>25</option>
                                    <option value="50" @if($setting->payload === '50') selected @endif>50</option>
                                    <option value="100" @if($setting->payload === '100') selected @endif>100</option>
                                </select>
                            @else
                                <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}" value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-700 text-black focus:outline-none focus:border-blue-500 text-lg">
                            @endif
                        </div>
                    @endforeach
                @endif
            @endforeach
            <button type="submit" class="bg-white text-black px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue text-lg">Save Changes</button>
        </form>
    </div>
</x-admin-layout>
