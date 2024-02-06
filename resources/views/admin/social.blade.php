<x-admin-layout>
    <div class="min-h-screen">
        <?php
        $textColorclass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black';
        $bgColorclass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'black' : 'white';
        $socialMediaStyles = [
            'facebook' => ['#3B5998', 'fa fa-facebook'],
            'instagram' => ['#125688', 'fa fa-instagram'],
            'twitter' => ['#55ACEE', 'fa fa-twitter'],
            'youtube' => ['#bb0000', 'fa fa-youtube'],
        ];
        ?>
        <p class="text-4xl font-bold mb-6 text-{{ $textColorclass }}">
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
                                class="block text-lg font-semibold text-{{ $textColorclass }}">{{ $setting->name }}</label>
                            <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}"
                                value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}"
                                class="w-full px-4 py-2 border border-gray-700 rounded-md bg-{{ $bgColorclass }} text-{{ $textColorclass }} focus:outline-none focus:border-blue-500 text-lg"
                                required>
                        </div>
                    @endforeach
                @endif
            @endforeach
            <button type="submit"
                class="bg-{{ $textColorclass }} text-{{ $bgColorclass }} px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue text-lg">Save
                Changes</button>
        </form>

        @foreach ($groupedSettings['social'] as $setting)
            @if (isset($socialMediaStyles[$setting->name]))
                @php
                    [$backgroundColor, $iconClass] = $socialMediaStyles[$setting->name];
                @endphp
                <a href="{{ $setting->payload }}"
                    style="color:white;background-color:{{ $backgroundColor }};font-size:36px"
                    class="{{ $iconClass }}"></a>
            @endif
        @endforeach
    </div>
</x-admin-layout>
