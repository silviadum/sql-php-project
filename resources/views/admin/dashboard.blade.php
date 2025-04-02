<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            margin-bottom: 30px;
            font-size: 36px;
        }
        .rapoarte-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .raport-link {
            background-color: #f3f4f6;
            padding: 15px;
            text-decoration: none;
            color: #1a0dab;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            font-size: 18px;
        }
        .raport-link:hover {
            background-color: #e5e7eb;
        }
        .logout-section {
            margin-top: 30px;
            text-align: right;
        }
        .logout-btn {
            padding: 10px 20px;
            background-color: #ef4444;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rapoarte Disponibile:</h1>

        <div class="rapoarte-grid">
            <a href="{{ route('admin.rapoarte.clase') }}" class="raport-link">Clase Populate</a>
            <a href="{{ route('admin.rapoarte.echipamente') }}" class="raport-link">Echipamente pe Săli</a>
            <a href="{{ route('admin.rapoarte.membri') }}" class="raport-link">Membri și Antrenori</a>
            <a href="{{ route('admin.rapoarte.abonamente') }}" class="raport-link">Abonamente Active</a>
            <a href="{{ route('admin.rapoarte.antrenori') }}" class="raport-link">Statistici Antrenori</a>
            <a href="{{ route('admin.rapoarte.top-membri') }}" class="raport-link">Top Membri</a>
            <a href="{{ route('admin.rapoarte.sali') }}" class="raport-link">Utilizare Săli</a>
            <a href="{{ route('admin.rapoarte.statistici-abonamente') }}" class="raport-link">Statistici Abonamente</a>
            <a href="{{ route('admin.rapoarte.venituri-antrenori') }}" class="raport-link">Venituri pe Antrenor</a>
            <a href="{{ route('admin.rapoarte.participare-membri-clase') }}" class="raport-link">Participare Membri la Clase</a>
        </div>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>