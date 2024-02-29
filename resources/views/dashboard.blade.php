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
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            .nav-link-container {
                width: 150px;
                height: 150px;
                background-color: #f4f1f1;
                border-radius: 8px;
                overflow: hidden;
                margin: 0 10px 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                transition: background-color 0.3s ease;
            }

            .nav-link {
                text-decoration: none;
                color: #000000;
                font-size: 1.5rem;
                text-align: center;
            }

            .nav-link-container:hover {
                background-color: #777;
            }

            @media screen and (max-width: 768px) {
                .nav-link-container {
                    width: 100%;
                    margin: 0 0 20px;
                }
            }
        </style>
    </head>

    <body>

        <div class="header">
            <p style="font-size: 3rem;color:darkgray">Phpshort</p>
            <p style="font-size: 2rem">Overview</p>
        </div>

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
