<x-admin-layout>
    <div class="min-h-screen">
        <form method="POST" action="{{ route('admin.social.update') }}" class="w-full p-6 rounded-lg shadow-md bg-gray-800" enctype="multipart/form-data">
            @csrf
            @foreach($groupedSettings as $group => $groupSettings)
                @if($group === 'social')
                    @foreach($groupSettings as $setting)
                        <div class="mb-4">
                            <label for="{{ $setting->name }}" class="block text-lg font-semibold text-white">{{ $setting->name }}</label>
                            <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}" value="{{ $setting->payload }}" placeholder="{{ $setting->payload }}" class="w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-700 text-white focus:outline-none focus:border-blue-500 text-lg" required>
                        </div>
                    @endforeach
                @endif
            @endforeach
            <button type="submit" class="bg-white text-black px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue text-lg">Save Changes</button>
        </form>
             @foreach($groupSettings as $setting)
                 @if($setting->name === 'facebook')
                    <a href={{ $setting->payload }} style="color:white;background-color:#3B5998;font-size:16px" class="fa fa-facebook"></a>
                @endif
            @endforeach
            @foreach($groupSettings as $setting)
                 @if($setting->name === 'instagram')
                    <a href={{ $setting->payload }} style="color:white;background-color:#125688;font-size:16px" class="fa fa-instagram"></a>
                @endif
            @endforeach
            @foreach($groupSettings as $setting)
                 @if($setting->name === 'twitter')
                    <a href={{ $setting->payload }} style="color:white;background-color:#55ACEE;font-size:16px" class="fa fa-twitter"></a>
                @endif
            @endforeach
            @foreach($groupSettings as $setting)
                 @if($setting->name === 'youtube')
                    <a href={{ $setting->payload }} style="color:white;background-color:#bb0000;font-size:16px" class="fa fa-youtube"></a>
                @endif
            @endforeach
    </div>
</x-admin-layout>
