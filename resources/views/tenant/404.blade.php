<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Sayfa Bulunamadı</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 60px 40px;
            max-width: 600px;
            text-align: center;
        }

        .error-code {
            font-size: 8em;
            font-weight: bold;
            color: #667eea;
            line-height: 1;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s, transform 0.3s;
        }

        .btn:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }

        .emoji {
            font-size: 4em;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="error-container">
    <div class="emoji">🔍</div>
    <div class="error-code">404</div>
    <h1>Sayfa Bulunamadı</h1>
    <p>Aradığınız sayfa mevcut değil veya taşınmış olabilir.</p>
    <a href="/" class="btn">← Ana Sayfaya Dön</a>
</div>
</body>
</html>
