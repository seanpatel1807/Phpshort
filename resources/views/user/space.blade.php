<x-app-layout>

    <head>
        <style>
            .links-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .links-table th,
            .links-table td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            .links-table th {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
        <h2>Spaces:</h2>
        <a href="{{ route('showForm') }}" style="text-decoration: none;">
            <button style="padding: 10px; background-color: #7b60fb; color: #fff; border: none; cursor: pointer;">
                New
            </button>
        </a>
    </div>
    <table class="links-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Links</th>
                <th>Created at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($spaces as $space)
                <tr>
                    <td>{{ $space->id }}</td>
                    <td>{{ $space->space_name }}</td>
                    <td>{{ $space->links_count }}</td>
                    <td>{{ $space->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</x-app-layout>
