<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Under Development</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9fafb;
        }

        .container {
            text-align: center;
        }

        h1 {
            font-size: 3rem;
            color: #fbbf24; /* Yellow color */
        }

        p {
            font-size: 1.2rem;
            color: #6b7280; /* Gray color */
        }

        .emoji {
            font-size: 4rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="emoji">🚧</div>
            <h1>Page Under Development</h1>
            <p>We're working hard to bring this page to life! Check back soon.</p>
        </div>
        <div class="row">
            <a href="{{ route('dashboard') }}">← Back to Home.</a>
        </div>
    </div>
</body>
</html>