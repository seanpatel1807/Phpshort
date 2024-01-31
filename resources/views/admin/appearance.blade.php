<x-admin-layout>
    <div class="min-h-screen" style="background-color: {{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? '#333333' : '#ffffff' }}">
        <form method="POST" action="{{ route('admin.appearance.update') }}" class="w-full p-6 rounded-lg shadow-md" enctype="multipart/form-data">
            @csrf
            @foreach($groupedSettings as $group => $groupSettings)
                @if($group === 'appearance')
                    @foreach($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}" class="block text-lg font-semibold text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }}">
                                {{ $setting->name }}
                            </label>
                            @if($setting->name === 'theme')
                                <select id="{{ $setting->name }}" name="{{ $setting->name }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} focus:outline-none focus:border-blue-500 text-lg">
                                    <option value="light" @if($setting->payload === 'light') selected @endif>Light</option>
                                    <option value="dark" @if($setting->payload === 'dark') selected @endif>Dark</option>
                                </select>
                            @elseif($setting->name === 'custom_js')
                                <textarea id="{{ $setting->name }}" name="{{ $setting->name }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} focus:outline-none focus:border-blue-500 text-lg" rows="4" placeholder="{{ $setting->payload }}">{{ $setting->payload }}</textarea>
                            @elseif(in_array($setting->name, ['logo', 'favicon']))
                                <input type="file" id="{{ $setting->name }}" name="{{ $setting->name }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} focus:outline-none focus:border-blue-500 text-lg">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endif
                            @else
                                <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}" value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} focus:outline-none focus:border-blue-500 text-lg" required>
                            @endif
                        </div>
                    @endforeach
                @endif
            @endforeach
            <button type="submit" class="bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue text-lg">Save Changes</button>
        </form>
    </div>
</x-admin-layout>
