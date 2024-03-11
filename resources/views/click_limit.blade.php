<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maximum Click Count Reached</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        p {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #7b60fb;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #6042f8;
        }
    </style>
</head>

<body>

    <p>Maximum click count reached</p>

    <a href="{{ route('user.link') }}">Back</a>

</body>

</html>
