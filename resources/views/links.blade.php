<x-admin-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Links and Users</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 2px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            a {
                text-decoration: none;
                color: #007BFF;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Short URL</th>
                    <th>User</th>
                    <th>Click Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($links as $link)
                    <tr>
                        <td><a href="{{ $link->short_url }}"
                                target="_blank">https://127.0.0.1:8000/{{ $link->short_url }}</a></td>
                        <td>{{ $link->user->name }}</td>
                        <td>{{ $link->click_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    </html>
</x-admin-layout>
