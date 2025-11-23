<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Gerekli - Multi-Tenant Sistemi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 60px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .error-icon {
            font-size: 5em;
            color: #f59e0b;
            margin-bottom: 30px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        h1 {
            color: #1f2937;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .error-message {
            color: #6b7280;
            font-size: 1.2em;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .hint-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
            text-align: left;
        }

        .hint-box h3 {
            color: #92400e;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hint-box p {
            color: #78350f;
            margin: 0;
        }

        .tenant-list {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }

        .tenant-list h4 {
            color: #374151;
            margin-bottom: 15px;
        }

        .tenant-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            margin: 5px 0;
            background: white;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .tenant-item:hover {
            background: #e5e7eb;
            transform: translateX(5px);
        }

        .tenant-item a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            flex: 1;
        }

        .tenant-item a:hover {
            text-decoration: underline;
        }

        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .code {
            background: #1f2937;
            color: #10b981;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        
        <h1>Tenant Gerekli</h1>
        
        <div class="error-message">
            {{ $message ?? 'Bu işlem sadece tenant domain\'lerinde yapılabilir.' }}
        </div>

        <div class="hint-box">
            <h3>
                <i class="fas fa-info-circle"></i>
                Ne Yapmalıyım?
            </h3>
            <p>
                {{ $hint ?? 'Lütfen bir tenant domain\'ine gidin. Merkezi domain\'de (localhost) kullanıcı işlemleri yapılamaz.' }}
            </p>
        </div>

        <div class="tenant-list">
            <h4><i class="fas fa-building"></i> Mevcut Tenant'lar:</h4>
            @php
                try {
                    $tenants = \App\Models\Tenant::with('domains')->get();
                } catch (\Exception $e) {
                    $tenants = collect();
                }
            @endphp
            @if($tenants->count() > 0)
                @foreach($tenants as $tenant)
                    @if($tenant->domains->isNotEmpty())
                        @foreach($tenant->domains as $domain)
                            <div class="tenant-item">
                                <i class="fas fa-globe" style="color: #667eea;"></i>
                                <a href="http://{{ $domain->domain }}:8004" target="_blank">
                                    {{ $domain->domain }}
                                </a>
                                <span style="color: #6b7280; font-size: 0.9em;">({{ $tenant->id }})</span>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @else
                <p style="color: #6b7280;">Henüz tenant oluşturulmamış.</p>
            @endif
        </div>

        <a href="{{ url('/tenants') }}" class="btn">
            <i class="fas fa-list"></i>
            Tenant'ları Görüntüle
        </a>
    </div>
</body>
</html>

