<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ tenant('id') }} - Dashboard</title>
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

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .navbar h2 {
            color: #667eea;
            font-size: 1.5em;
        }

        .navbar .tenant-name {
            background: #667eea;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .card-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        .card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.3em;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        .info-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .info-section h2 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .info-item strong {
            color: #667eea;
            display: block;
            margin-bottom: 8px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-item span {
            color: #333;
            font-size: 1.1em;
            word-break: break-all;
        }

        .badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            transition: background 0.3s ease;
            margin-top: 15px;
        }

        .btn:hover {
            background: #764ba2;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 10px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="navbar">
        <h2>🏢 {{ strtoupper(tenant('id')) }} Dashboard</h2>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="/profile" style="text-decoration: none; color: #667eea; font-weight: 600;">👤 Profil</a>
            <div class="tenant-name">{{ tenant('id') }}</div>
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <div class="card-icon">👥</div>
            <h3>Kullanıcı Yönetimi</h3>
            <p>Tenant'ınıza ait kullanıcıları yönetin, yeni kullanıcılar ekleyin ve yetkilendirme yapın.</p>
            <a href="/users" class="btn">Kullanıcılar</a>
        </div>

        <div class="card">
            <div class="card-icon">📊</div>
            <h3>Raporlar</h3>
            <p>Detaylı raporlar oluşturun, verileri analiz edin ve performans metriklerini görüntüleyin.</p>
            <a href="/reports" class="btn">Raporlara Git</a>
        </div>

        <div class="card">
            <div class="card-icon">⚙️</div>
            <h3>Ayarlar</h3>
            <p>Tenant ayarlarını yapılandırın, tema değiştirin ve sistem tercihlerini düzenleyin.</p>
            <a href="/settings" class="btn">Ayarlar</a>
        </div>
    </div>

    <div class="info-section">
        <h2>📋 Tenant Bilgileri</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Tenant ID</strong>
                <span>{{ tenant('id') }}</span>
            </div>

            <div class="info-item">
                <strong>Domain</strong>
                <span>{{ tenant()->domains->first()->domain }}</span>
            </div>

            <div class="info-item">
                <strong>Veritabanı</strong>
                <span>{{ tenant()->tenancy_db_name }}</span>
            </div>

            <div class="info-item">
                <strong>Oluşturulma Tarihi</strong>
                <span>{{ tenant()->created_at->format('d.m.Y H:i') }}</span>
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <span class="badge">✅ Multi-tenancy Aktif</span>
        </div>
    </div>
</div>
</body>
</html>
