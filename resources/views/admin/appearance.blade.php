<x-admin-layout>
    <div class="bg-black min-h-screen" style="width: 180vh">
        <form method="POST" action="" class="w-full max-w-md p-6 rounded-lg shadow-md bg-gray-800">
            @csrf
            @foreach($groupedSettings as $group => $groupSettings)
                @if($group === 'appearance')
                    @foreach($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}" class="block text-lg font-semibold text-white">{{ $setting->name }}</label>
                            <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}" value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-700 text-white focus:outline-none focus:border-blue-500 text-lg">
                        </div>
                    @endforeach
                @endif
            @endforeach
            <button type="submit" class="bg-white text-black px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue text-lg">Save Changes</button>
        </form>
    </div>
</x-admin-layout>
