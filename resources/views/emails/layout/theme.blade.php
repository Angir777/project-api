<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            font-size: 16px;
            color: #666;
            text-align: center;
        }

        a {
            display: inline-block;
            padding: 15px 30px;
            background-color: #3490dc;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }

        footer {
            padding: 20px 0;
            text-align: center;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    @yield('content')

    <footer>
        This email is a test message sent to you. If you have any questions, feel free to contact us.
    </footer>
</body>
</html>
