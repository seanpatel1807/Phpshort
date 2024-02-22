<x-app-layout>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
        }

        .center-container {
            width: 800px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .pixel-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .pixel-table th,
        .pixel-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .pixel-table th {
            background-color: #f2f2f2;
        }
    </style>

    <a href="{{ route('pixel.create') }}" style="background-color:#7b60fb;padding:10px">
        <button>Create Pixel</button>
    </a>
    <form action="{{ route('user.pixel') }}" method="get">
        <input type="text" name="query" placeholder="Search pixels" value="{{ $query }}"
            style="margin-top: 30px">
        <button type="submit" style="background-color:#7b60fb;padding:10px ">Search</button>
    </form>
    <br>
    <div class="container">
        <div class="center-container">
            <h2>List of Pixels</h2>
            @if ($pixels->isEmpty())
                <p>No pixels found.</p>
            @else
                <table class="pixel-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>links</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pixels as $pixel)
                            <tr>
                                <td>{{ $pixel->name }}</td>
                                <td>{{ $pixel->type }}</td>
                                <td>{{ $pixel->links_count }}</td>
                                <td>
                                    <form action="{{ route('pixels.destroy', ['id' => $pixel->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            style="background-color: red;padding:10px">Delete</button>
                                    </form>
                                </td>
                                <td> <a href="{{ route('pixels.edit', ['id' => $pixel->id]) }}"
                                        class="btn btn-info">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
