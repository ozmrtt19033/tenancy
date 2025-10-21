<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Tenant Oluştur</title>
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
            padding: 50px;
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95em;
        }

        input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .help-text {
            font-size: 0.85em;
            color: #999;
            margin-top: 5px;
        }

        .error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .buttons {
            display: flex;
            gap: 15px;
            margin-top: 40px;
        }

        .btn {
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1em;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            flex: 1;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .info-box strong {
            color: #1976d2;
            display: block;
            margin-bottom: 5px;
        }

        .info-box ul {
            margin-left: 20px;
            color: #555;
            font-size: 0.9em;
        }

        .info-box li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🚀 Yeni Tenant Oluştur</h1>
    <p class="subtitle">Yeni bir müşteri/şirket ekleyin</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <span>⚠️</span>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="info-box">
        <strong>📝 Bilgi</strong>
        <ul>
            <li>Tenant ID sadece küçük harf, rakam ve tire içerebilir</li>
            <li>Domain .localhost kullanabilirsiniz (örn: firma.localhost)</li>
            <li>Otomatik olarak veritabanı oluşturulacak</li>
        </ul>
    </div>

    <form action="{{ route('tenants.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Tenant ID *</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="ornek: acme, firma1, demo"
                value="{{ old('name') }}"
                required
            >
            <div class="help-text">Sadece küçük harf, rakam ve tire (-) kullanın</div>
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="domain">Domain *</label>
            <input
                type="text"
                id="domain"
                name="domain"
                placeholder="ornek: firma.localhost, acme.localhost"
                value="{{ old('domain') }}"
                required
            >
            <div class="help-text">Development için .localhost uzantısı kullanın</div>
            @error('domain')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="buttons">
            <a href="{{ route('tenants.index') }}" class="btn btn-secondary">
                ← İptal
            </a>
            <button type="submit" class="btn btn-primary">
                ✓ Oluştur
            </button>
        </div>
    </form>
</div>

<script>
    // Tenant ID otomatik format
    document.getElementById('name').addEventListener('input', function(e) {
        this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
    });

    // Domain otomatik format
    document.getElementById('domain').addEventListener('input', function(e) {
        this.value = this.value.toLowerCase().replace(/[^a-z0-9.-]/g, '');
    });

    // Form submit öncesi son kontrol
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value;
        const domain = document.getElementById('domain').value;

        if (!name || !domain) {
            e.preventDefault();
            alert('Lütfen tüm alanları doldurun!');
            return false;
        }

        if (!/^[a-z0-9-]+$/.test(name)) {
            e.preventDefault();
            alert('Tenant ID sadece küçük harf, rakam ve tire içerebilir!');
            return false;
        }
    });
</script>
</body>
</html>
