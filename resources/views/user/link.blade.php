<x-app-layout>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .message-box {
                background-color: #4CAF50;
                color: white;
                padding: 15px;
                margin-bottom: 20px;
                display: block;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: opacity 0.5s ease-in-out;
            }

            .message-box.hide {
                opacity: 0;
                pointer-events: none;
            }

            .short-link {
                background-color: #7b60fb;
                color: white;
                padding: 10px;
                margin: 10px;
                width: 120px;
                height: auto;
                border-radius: 5px;
                display: none;
                transition: opacity 0.5s ease-in-out;
            }

            .short-link.show {
                display: flex;
                opacity: 1;
            }

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

            .delete-button {
                background-color: #ff0000;
                color: #ffffff;
                border: none;
                padding: 5px 10px;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <div>
            @if (isset($message))
                <div id="message-box" class="message-box hide">
                    <p>{{ $message }}</p>
                </div>
                <script>
                    document.getElementById('message-box').classList.remove('hide');
                    setTimeout(function() {
                        document.getElementById('message-box').style.opacity = '0';
                        setTimeout(function() {
                            document.getElementById('message-box').style.display = 'none';
                        }, 500);
                    }, 5000);
                </script>
            @endif

            <div id="short-link" class="short-link show">
                <p>
                    Short Link:
                    @isset($shortUrl)
                        <a href="{{ $shortUrl }}" target="blank">{{ $shortUrl }}</a>
                    @else
                        No link available
                    @endisset
                </p>
            </div>

            <script>
                setTimeout(function() {
                    document.getElementById('short-link').style.opacity = '0';
                    setTimeout(function() {
                        document.getElementById('short-link').style.display = 'none';
                    }, 500);
                }, 5000);
            </script>

            <form method="POST" action="/create-link" class="flex" style="gap:10px">
                @csrf
                <textarea class="w-full" type="url" id="original_url" name="original_url" placeholder="Type or paste the link"
                    required></textarea>
                <button type="submit" style="background-color:#7b60fb; padding:10px">Shorten</button>
            </form>
        </div>

        <h2>All Links:</h2>

        <table class="links-table">
            <thead>
                <tr>
                    <th>Short URL</th>
                    <th>Click count</th>
                    <th>Created At</th>
                    <th>function</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allLinks as $link)
                    <tr>
                        <td><a href="{{ $link->short_url }}" target="_blank">https://127.0.0.1:8000/{{ $link->short_url }}</a></td>
                        <td>{{ $link->click_count }}</td>
                        <td>{{ $link->created_at }}</td>
                        <td>
                            <form action="{{ route('delete.link', ['id' => $link->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this link?')"
                                    class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

    </html>
</x-app-layout>
