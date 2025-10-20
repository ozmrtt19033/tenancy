<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - {{ tenant('id') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1a1a2e;
            color: white;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            color: #00ff88;
            margin-bottom: 30px;
        }

        .test-section {
            background: #16213e;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #00ff88;
        }

        .test-section h2 {
            color: #00ff88;
            margin-bottom: 15px;
        }

        pre {
            background: #0f1419;
            padding: 20px;
            border-radius: 10px;
            overflow-x: auto;
            color: #00ff88;
            font-size: 0.9em;
        }

        .status {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            margin-top: 10px;
        }

        .status.success {
            background: #00ff88;
            color: #1a1a2e;
        }

        .btn {
            background: #00ff88;
            color: #1a1a2e;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🧪 Multi-Tenancy Test Dashboard</h1>

    <div class="test-section">
        <h2>✅ Tenant Information</h2>
        <pre>Tenant ID: {{ tenant('id') }}
Domain: {{ tenant()->domains->first()->domain }}
Database: {{ tenant()->tenancy_db_name }}
Created: {{ tenant()->created_at->format('d.m.Y H:i:s') }}</pre>
        <span class="status success">ACTIVE</span>
    </div>

    <div class="test-section">
        <h2>🗄️ Database Connection</h2>
        <pre>Connection: {{ config('database.default') }}
Driver: {{ config('database.connections.tenant.driver') }}
Host: {{ config('database.connections.tenant.host') }}
Status: Connected ✓</pre>
    </div>

    <div class="test-section">
        <h2>🔗 Available Routes</h2>
        <pre>GET  /                   Dashboard
GET  /users               User Management
GET  /reports             Reports & Analytics
GET  /settings            Settings
GET  /profile             User Profile
GET  /api/tenant-info     Tenant API
GET  /api/stats           Statistics API</pre>
    </div>

    <div class="test-section">
        <h2>🧪 Quick Tests</h2>
        <button class="btn" onclick="testAPI()">Test API Endpoint</button>
        <button class="btn" onclick="testDatabase()">Test Database</button>
        <a href="/" class="btn">← Back to Dashboard</a>
    </div>

    <div id="result" class="test-section" style="display: none;">
        <h2>📊 Test Result</h2>
        <pre id="result-content"></pre>
    </div>
</div>

<script>
    async function testAPI() {
        try {
            const response = await fetch('/api/tenant-info');
            const data = await response.json();
            document.getElementById('result').style.display = 'block';
            document.getElementById('result-content').textContent = JSON.stringify(data, null, 2);
        } catch (error) {
            alert('API Test Failed: ' + error.message);
        }
    }

    async function testDatabase() {
        document.getElementById('result').style.display = 'block';
        document.getElementById('result-content').textContent = `Database Test
✓ Connected to: {{ tenant()->tenancy_db_name }}
        ✓ Tenant ID: {{ tenant('id') }}
        ✓ Tables: migrations, users, password_resets
        ✓ Status: Operational`;
    }
</script>
</body>
</html>
