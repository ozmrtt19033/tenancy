<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - {{ tenant('id') }}</title>
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
            max-width: 900px;
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

        .profile-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #e9ecef;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3em;
            color: white;
        }

        .profile-info h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .profile-info p {
            color: #666;
            font-size: 1.1em;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }

        .info-item label {
            display: block;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-item .value {
            color: #333;
            font-size: 1.1em;
        }

        .btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
            margin-right: 10px;
        }

        .btn:hover {
            background: #764ba2;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .activity-log {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #e9ecef;
        }

        .activity-log h3 {
            color: #333;
            margin-bottom: 20px;
        }

        .activity-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .activity-item .icon {
            font-size: 1.5em;
            margin-right: 15px;
        }

        .activity-time {
            color: #999;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>👤 Profil</h1>
        <a href="/" class="btn btn-secondary">← Geri</a>
    </div>

    <div class="profile-section">
        <div class="profile-header">
            <div class="avatar">👤</div>
            <div class="profile-info">
                <h2>Admin User</h2>
                <p>admin@{{ tenant('id') }}.com</p>
                <p style="margin-top: 5px; color: #667eea; font-weight: 600;">Sistem Yöneticisi</p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <label>Tenant</label>
                <div class="value">{{ strtoupper(tenant('id')) }}</div>
            </div>

            <div class="info-item">
                <label>Domain</label>
                <div class="value">{{ tenant()->domains->first()->domain }}</div>
            </div>

            <div class="info-item">
                <label>Üyelik Tarihi</label>
                <div class="value">{{ tenant()->created_at->format('d.m.Y') }}</div>
            </div>

            <div class="info-item">
                <label>Son Giriş</label>
                <div class="value">{{ now()->format('d.m.Y H:i') }}</div>
            </div>

            <div class="info-item">
                <label>Telefon</label>
                <div class="value">+90 (555) 123-4567</div>
            </div>

            <div class="info-item">
                <label>Departman</label>
                <div class="value">Yönetim</div>
            </div>
        </div>

        <button class="btn">Profili Düzenle</button>
        <button class="btn btn-secondary">Şifre Değiştir</button>

        <div class="activity-log">
            <h3>📋 Son Aktiviteler</h3>
            <div class="activity-item">
                <div style="display: flex; align-items: center;">
                    <span class="icon">🔐</span>
                    <div>
                        <strong>Başarılı giriş</strong>
                        <div class="activity-time">{{ now()->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="activity-item">
                <div style="display: flex; align-items: center;">
                    <span class="icon">⚙️</span>
                    <div>
                        <strong>Ayarlar güncellendi</strong>
                        <div class="activity-time">{{ now()->subHours(2)->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="activity-item">
                <div style="display: flex; align-items: center;">
                    <span class="icon">👥</span>
                    <div>
                        <strong>Yeni kullanıcı eklendi</strong>
                        <div class="activity-time">{{ now()->subDay()->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
