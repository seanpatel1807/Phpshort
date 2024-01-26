<x-admin-layout>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b border-gray-500">Group</th>
                <th class="py-2 px-4 border-b border-gray-500">Name</th>
                <th class="py-2 px-4 border-b border-gray-500">Payload</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupedSettings as $group => $groupSettings)
                @if($group === 'appearance')
                    @foreach($groupSettings as $setting)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $setting->group }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $setting->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $setting->payload }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
</x-admin-layout>
