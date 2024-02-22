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
        <h2>Pixels Information</h2>
    </div>
    <form action="{{ route('pixels') }}" method="get">
        <input type="text" name="query" placeholder="Search pixels" value="{{ $query }}">
        <button type="submit"
            style="padding: 10px; background-color: #7b60fb; color: #fff; border: none; cursor: pointer;">Search</button>
    </form>
    <table class="links-table">
        <thead>
            <tr>
                <th>Pixels Name</th>
                <th>User Name</th>
                <th>Links Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $users)
                <tr>
                    <td>{{ $users->name }}</td>
                    <td>{{ $users->user_name }}</td>
                    <td>{{ $users->links_count }}</td>
                    <td>
                        <form action="{{ route('pixels.destroy', $users->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: red;color:white;padding:3px">Delete</button>
                        </form>
                    </td>
                    <td> <a href="{{ route('pixels.edit', $users->id) }}" style="text-decoration: none;">
                            <button
                                style="background-color: #3490dc; color: white; padding: 3px; margin-left: 5px;">Edit</button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</x-admin-layout>
