<x-admin-layout>

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
        <h2>Spaces Information</h2>
    </div>
    <table class="links-table">
        <thead>
            <tr>
                <th>Space Name</th>
                <th>User Name</th>
                <th>Links Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $users)
                <tr>
                    <td>{{ $users->space_name }}</td>
                    <td>{{ $users->user_name }}</td>
                    <td>{{ $users->links_count }}</td>
                    <td>
                        <form action="{{ route('spaces.delete', $users->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: red;color:white;padding:3px">Delete</button>
                        </form>
                    </td>
                    <td> <a href="{{ route('spaces.edit', $users->id) }}" style="text-decoration: none;">
                            <button
                                style="background-color: #3490dc; color: white; padding: 3px; margin-left: 5px;">Edit</button>
                        </a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</x-admin-layout>
