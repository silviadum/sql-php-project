<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonamente Disponibile</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .abonamente-list {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .abonament-card {
            border: 1px solid #ddd;
            padding: 20px;
            width: 300px;
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Abonamente Disponibile</h1>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <div class="abonamente-list">
            @foreach($abonamente as $abonament)
                <div class="abonament-card">
                    <h3>{{ $abonament->tip_abonament }}</h3>
                    <p class="pret">{{ $abonament->pret }} RON / lună</p>
                    
                    <form action="{{ route('abonamente.cumpara') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tip_abonament" value="{{ $abonament->tip_abonament }}">
                        <button type="submit">Cumpără Abonament</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>