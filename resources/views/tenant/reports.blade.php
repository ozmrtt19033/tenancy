<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raporlar - {{ tenant('id') }}</title>
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
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 2.5em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 1em;
        }

        .chart-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .btn {
            background: #667eea;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #764ba2;
        }

        .chart-placeholder {
            height: 300px;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 1.2em;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📊 Raporlar ve Analitik</h1>
        <a href="/" class="btn">← Geri</a>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-value">247</div>
            <div class="stat-label">Toplam Kullanıcı</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📈</div>
            <div class="stat-value">1,842</div>
            <div class="stat-label">Aylık İşlem</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-value">₺45,230</div>
            <div class="stat-label">Aylık Gelir</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⭐</div>
            <div class="stat-value">98%</div>
            <div class="stat-label">Memnuniyet</div>
        </div>
    </div>

    <div class="chart-section">
        <h2 style="color: #333; margin-bottom: 20px;">Aylık Performans</h2>
        <div class="chart-placeholder">
            📊 Grafik gösterimi için Chart.js entegrasyonu yapılabilir
        </div>
    </div>
</div>
</body>
</html>
