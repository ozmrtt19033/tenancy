<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcılar - {{ tenant('id') }}</title>
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

        .header h1 {
            color: #333;
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

        .btn-secondary {
            background: #6c757d;
        }

        .users-table {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #667eea;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background 0.3s;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .badge-success {
            background: #10b981;
            color: white;
        }

        .badge-warning {
            background: #f59e0b;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            color: #666;
        }

        .empty-state-icon {
            font-size: 4em;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            table {
                font-size: 0.9em;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>👥 Kullanıcı Yönetimi</h1>
        <div>
            <a href="/" class="btn btn-secondary" style="margin-right: 10px;">← Geri</a>
            <a href="/users/create" class="btn">+ Yeni Kullanıcı</a>
        </div>
    </div>

    <div class="users-table">
        <h2 style="margin-bottom: 20px; color: #333;">Kullanıcı Listesi</h2>

        @php
            // Demo kullanıcılar
            $users = [
                ['id' => 1, 'name' => 'Admin User', 'email' => 'admin@' . tenant('id') . '.com', 'role' => 'Admin', 'status' => 'Aktif'],
                ['id' => 2, 'name' => 'John Doe', 'email' => 'john@' . tenant('id') . '.com', 'role' => 'Kullanıcı', 'status' => 'Aktif'],
                ['id' => 3, 'name' => 'Jane Smith', 'email' => 'jane@' . tenant('id') . '.com', 'role' => 'Kullanıcı', 'status' => 'Pasif'],
            ];
        @endphp

        @if(count($users) > 0)
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['role'] }}</td>
                        <td>
                                <span class="badge {{ $user['status'] === 'Aktif' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $user['status'] }}
                                </span>
                        </td>
                        <td>
                            <a href="/users/{{ $user['id'] }}/edit" style="color: #667eea; text-decoration: none;">Düzenle</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h3>Henüz kullanıcı yok</h3>
                <p>İlk kullanıcınızı eklemek için "Yeni Kullanıcı" butonuna tıklayın.</p>
            </div>
        @endif
    </div>
</div>
</body>
</html>
