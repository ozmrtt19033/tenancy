<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayarlar - {{ tenant('id') }}</title>
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

        .settings-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        .settings-section h2 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #764ba2;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #667eea;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>⚙️ Ayarlar</h1>
        <a href="/" class="btn btn-secondary">← Geri</a>
    </div>

    <div class="settings-section">
        <h2>Genel Ayarlar</h2>
        <form>
            <div class="form-group">
                <label>Şirket Adı</label>
                <input type="text" value="{{ strtoupper(tenant('id')) }}" placeholder="Şirket adınız">
            </div>

            <div class="form-group">
                <label>E-posta Adresi</label>
                <input type="email" value="info@{{ tenant('id') }}.com" placeholder="info@example.com">
            </div>

            <div class="form-group">
                <label>Telefon</label>
                <input type="tel" placeholder="+90 (555) 555-5555">
            </div>

            <div class="form-group">
                <label>Adres</label>
                <textarea rows="3" placeholder="Tam adresiniz"></textarea>
            </div>

            <button type="submit" class="btn">Kaydet</button>
        </form>
    </div>

    <div class="settings-section">
        <h2>Bildirim Tercihleri</h2>
        <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <strong>E-posta Bildirimleri</strong>
                <p style="color: #666; font-size: 0.9em;">Önemli güncellemeler için e-posta alın</p>
            </div>
            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>
        </div>

        <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <strong>SMS Bildirimleri</strong>
                <p style="color: #666; font-size: 0.9em;">Acil durumlar için SMS alın</p>
            </div>
            <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <div class="settings-section">
        <h2>Tema Ayarları</h2>
        <div class="form-group">
            <label>Renk Teması</label>
            <select>
                <option>Mor (Varsayılan)</option>
                <option>Mavi</option>
                <option>Yeşil</option>
                <option>Kırmızı</option>
            </select>
        </div>
        <button type="button" class="btn">Temayı Uygula</button>
    </div>
</div>
</body>
</html>
