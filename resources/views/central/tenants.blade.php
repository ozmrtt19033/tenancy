<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Listesi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        h1 {
            color: #333;
            font-size: 2em;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            padding: 8px 16px;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .tenant-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .tenant-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tenant-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .tenant-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 20px;
        }

        .tenant-name {
            font-size: 1.5em;
            font-weight: 700;
            color: #667eea;
            text-transform: uppercase;
        }

        .tenant-info {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .info-value {
            color: #333;
            font-size: 1em;
            word-break: break-all;
        }

        .domain-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .domain-link:hover {
            text-decoration: underline;
        }

        .tenant-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .empty-state {
            background: white;
            padding: 60px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .empty-state-emoji {
            font-size: 4em;
            margin-bottom: 20px;
        }

        .empty-state h2 {
            color: #666;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🏢 Tenant Listesi</h1>
        <div style="display: flex; gap: 10px;">
            <a href="{{ url('/') }}" class="btn btn-back">← Geri</a>
            <a href="{{ route('tenants.create') }}" class="btn btn-primary">+ Yeni Tenant</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="white-space: pre-line;">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($tenants->isEmpty())
        <div class="empty-state">
            <div class="empty-state-emoji">📦</div>
            <h2>Henüz tenant oluşturulmamış</h2>
            <p>İlk tenant'ınızı oluşturarak başlayın</p>
            <a href="{{ route('tenants.create') }}" class="btn btn-primary">Yeni Tenant Oluştur</a>
        </div>
    @else
        <div class="tenant-grid">
            @foreach($tenants as $tenant)
                <div class="tenant-card">
                    <div class="tenant-header">
                        <div class="tenant-name">{{ $tenant->id }}</div>
                        <span class="badge">Aktif</span>
                    </div>

                    <div class="tenant-info">
                        <div class="info-label">📍 Domain</div>
                        @if($tenant->domains && $tenant->domains->count() > 0)
                            @foreach($tenant->domains as $domain)
                                <div class="info-value">
                                    <a href="http://{{ $domain->domain }}:8004"
                                       target="_blank"
                                       class="domain-link">
                                        {{ $domain->domain }}
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="info-value text-muted">
                                <small>Domain yok</small>
                            </div>
                        @endif
                    </div>

                    <div class="tenant-info">
                        <div class="info-label">💾 Database</div>
                        <div class="info-value">tenant{{ $tenant->id }}</div>
                    </div>

                    <div class="tenant-info">
                        <div class="info-label">📅 Oluşturulma</div>
                        <div class="info-value">
                            @if($tenant->created_at)
                                {{ $tenant->created_at->format('d.m.Y H:i') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>

                    <div class="tenant-actions">
                        @if($tenant->domains && $tenant->domains->count() > 0)
                            <a href="http://{{ $tenant->domains->first()->domain }}:8004"
                               target="_blank"
                               class="btn btn-primary"
                               style="flex: 1; text-align: center;">
                                Aç →
                            </a>
                        @else
                            <button class="btn btn-primary"
                                    style="flex: 1; text-align: center;"
                                    disabled>
                                Domain Yok
                            </button>
                        @endif
                        <form action="{{ route('tenants.destroy', $tenant) }}"
                              method="POST"
                              onsubmit="return confirm('{{ $tenant->id }} tenant\'ını silmek istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">🗑️</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
