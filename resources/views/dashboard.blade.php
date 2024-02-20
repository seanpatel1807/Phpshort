<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Title</title>

        <style>
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            .navigation {

                padding: 10px;
                text-align: center;
                display: flex;
                justify-content: space-around;
            }

            .nav-link-container {
                background-color: #555;
                border-radius: 8px;
                overflow: hidden;
                margin: 0 10px;
            }

            .nav-link {
                display: block;
                padding: 10px;
                text-decoration: none;
                color: #fff;
                transition: background-color 0.3s ease;
            }

            .nav-link:hover {
                background-color: #777;
            }
        </style>
    </head>

    <body>

        <p style="font-size: 3rem;color:darkgray">
            Phpshort</p>
        <p style="font-size: 2rem">overview</p>

        <div class="navigation">
            <div class="nav-link-container">
                <a href="{{ route('user.link') }}" class="nav-link">Links</a>
            </div>
            <div class="nav-link-container">
                <a href="{{ route('user.space') }}" class="nav-link">Spaces</a>
            </div>
            <div class="nav-link-container">
                <a href="{{ route('user.domain') }}" class="nav-link">Domains</a>
            </div>
            <div class="nav-link-container">
                <a href="{{ route('user.pixel') }}" class="nav-link">Pixels</a>
            </div>
        </div>
    </body>
    </html>
</x-app-layout>
