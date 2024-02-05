<x-admin-layout>
    <div class="min-h-screen">
        <p
            class="text-4xl font-bold mb-6 text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }}">
            Social Settings
        </p>
        <form method="POST" action="{{ route('admin.social.update') }}" class="w-full p-6 rounded-lg shadow-md"
            enctype="multipart/form-data">
            @csrf
            @foreach ($groupedSettings as $group => $groupSettings)
                @if ($group === 'social')
                    @foreach ($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}"
                                class="block text-lg font-semibold text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }}">{{ $setting->name }}</label>
                            <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}"
                                value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}"
                                class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} focus:outline-none focus:border-blue-500 text-lg"
                                required>
                        </div>
                    @endforeach
                @endif
            @endforeach
            <button type="submit"
                class="bg-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white' }} px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue text-lg">Save
                Changes</button>
        </form>

        @foreach ($groupedSettings['social'] as $setting)
            @switch($setting->name)
                @case('facebook')
                    <a href="{{ $setting->payload }}" style="color:white;background-color:#3B5998;font-size:36px"
                        class="fa fa-facebook"></a>
                @break

                @case('instagram')
                    <a href="{{ $setting->payload }}" style="color:white;background-color:#125688;font-size:36px"
                        class="fa fa-instagram"></a>
                @break

                @case('twitter')
                    <a href="{{ $setting->payload }}" style="color:white;background-color:#55ACEE;font-size:36px"
                        class="fa fa-twitter"></a>
                @break

                @case('youtube')
                    <a href="{{ $setting->payload }}" style="color:white;background-color:#bb0000;font-size:36px"
                        class="fa fa-youtube"></a>
                @break
            @endswitch
        @endforeach
    </div>
</x-admin-layout>
