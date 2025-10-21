<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Tenant Yönetim Sistemi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 60px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .emoji {
            font-size: 4em;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            font-size: 1.2em;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin-top: 40px;
            text-align: left;
            border-radius: 8px;
        }

        .info-box h3 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .info-box ul {
            list-style: none;
            padding: 0;
        }

        .info-box li {
            padding: 8px 0;
            color: #555;
        }

        .info-box li:before {
            content: "✓ ";
            color: #667eea;
            font-weight: bold;
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="emoji">🏢</div>
    <h1>Multi-Tenant Sistemi</h1>
    <p>Laravel tabanlı çoklu kiracılık yönetim platformuna hoş geldiniz</p>

    <div class="buttons">
        <a href="{{ route('tenants.index') }}" class="btn btn-primary">
            Tenant'ları Görüntüle
        </a>
        <a href="{{ route('tenants.create') }}" class="btn btn-secondary">
            Yeni Tenant Oluştur
        </a>
    </div>

    <div class="info-box">
        <h3>📋 Sistemin Özellikleri</h3>
        <ul>
            <li>Her tenant için izole veritabanı</li>
            <li>Domain bazlı tenant tanıma</li>
            <li>Otomatik database migration</li>
            <li>Kolay tenant yönetimi</li>
            <li>Güvenli veri izolasyonu</li>
        </ul>
    </div>
</div>
</body>
</html>
