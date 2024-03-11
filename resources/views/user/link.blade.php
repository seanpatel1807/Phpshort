<x-app-layout>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Include Font Awesome for the cog icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
            integrity="sha512-RECEwJw5AeMu6p0oCkJKoVfwoQrBF1Y86hD/3zsZv7Cz5gOECM9D3AgpKsLsBtcdLp+I9uqov8FX1FssGpKjlg=="
            crossorigin="anonymous" />

        <style>
            .message-box {
                background-color: #4CAF50;
                color: white;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 8px;
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

            #settingsContainer {
                display: none;
                margin-top: 10px;
            }

            #settingsButton {
                background-color: #7b60fb;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-bottom: 10px;
            }

            .settings-field {
                margin-bottom: 10px;
                display: flow-root;
            }
        </style>

        <script>
            function toggleSettings() {
                var settingsContainer = document.getElementById('settingsContainer');
                settingsContainer.style.display = (settingsContainer.style.display === 'none') ? 'block' : 'none';
            }
        </script>
    </head>

    <body>

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

        @if ($errors->has('duplicate_link'))
            <div class="alert alert-danger">{{ $errors->first('duplicate_link') }}</div>
        @endif

        <button id="settingsButton" onclick="toggleSettings()">Settings <i class="fas fa-cog"></i></button>
        <div>
            <form method="POST" action="/create-link" class="flex" style="gap:10px">
                @csrf
                <textarea class="w-full" type="url" id="original_url" name="original_url" placeholder="Type or paste the link"
                    required></textarea>
        </div>
        <div>

            <!-- Settings container -->
            <div id="settingsContainer" style="display: none;">
                <label>space name
                    <select name="space_id" id="space_id" class="custom-dropdown settings-field">
                        @foreach ($allSpaces as $space)
                            <option value="{{ $space->id }}">{{ $space->space_name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>pixels
                    <select name="pixels_id" id="pixels_id" class="custom-dropdown settings-field">
                        @foreach ($allPixels as $pixel)
                            <option value="{{ $pixel->id }}">{{ $pixel->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>custom alias
                    <input type="text" name="uniqid" pattern="[a-zA-Z0-9-_]+" placeholder="Custom alias"
                        title="Only letters, numbers, dashes, and underscores are allowed." class="settings-field">
                </label>

                <label for="click_limit" class="settings-field">Click Limit (optional):
                    <input type="number" name="click_limit" min="1" class="settings-field"></label>
                <label for="expiration_date" class="settings-field">Expiration Date and Time:
                    <input type="datetime-local" name="expiration_date" class="settings-field"
                        min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                        value="{{ now()->addDay()->format('Y-m-d\TH:i') }}">
                </label>

                <div id="passwordField">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </div>
                <br>
                <div>
                    <label for="access_type">Access Type:</label>
                    <select name="access_type" id="access_type">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                        <option value="password">Password Protected</option>
                    </select>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Initially hide the password field
                        $('#passwordField').hide();

                        $('#access_type').change(function() {
                            if ($(this).val() === 'password') {
                                $('#passwordField').show();
                                $('#password').prop('required', true);
                            } else {
                                $('#passwordField').hide();
                                $('#password').prop('required', false);
                            }
                        });

                        // Trigger change event on page load to check the initial state
                        $('#access_type').trigger('change');
                    });
                </script>

            </div>
            <!-- Shorten button -->
            <button type="submit"
                style="background-color: #7b60fb;color: white;padding: 10px;border: none;border-radius: 5px;cursor: pointer;margin-top: 10px;">Shorten</button>
            </form>
        </div>
        <h2>All Links:</h2>
        @if (session('success'))
            <div id="message-box" class="message-box">
                <p>{{ session('success') }}</p>
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

        <table class="links-table">
            <thead>
                <tr>
                    <th>Short URL</th>
                    <th>Click count</th>
                    <th>Created At</th>
                    <th>Function</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allLinks->reverse() as $link)
                    <tr>
                        <td>
                            <a href="/{{ $link->short_url }}" target="_blank">
                                {{ $link->uniqid ? 'https://127.0.0.1:8000/' . $link->uniqid : 'https://127.0.0.1:8000/' . $link->short_url }}
                            </a>
                        </td>
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
                            <form action="{{ route('link.edit', ['id' => $link->id]) }}" method="get">
                                @csrf
                                <button type="submit"
                                    style="background-color:rgb(75, 105, 255);padding:10px;color:white">Edit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

    </html>
</x-app-layout>
