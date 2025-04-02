<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Sală Nouă</title>
</head>
<body>
    <h1>Adaugă Sală Nouă</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sali.store') }}" method="POST">
        @csrf
        <div>
            <label>Denumire Sală:</label>
            <input type="text" name="denumire_sala" required>
        </div>

        <div>
            <label>Capacitate:</label>
            <input type="number" name="capacitate" min="1" required>
        </div>

        <h3>Echipamente</h3>
        <div id="echipamente-container">
            @foreach($echipamente as $echipament)
                <div class="echipament-row">
                    <input type="checkbox" 
                           name="echipamente[]" 
                           value="{{ $echipament->id_echipament }}">
                    <label>{{ $echipament->denumire_echipament }}</label>
                    <input type="number" 
                           name="bucati[]" 
                           value="0" 
                           min="0">
                </div>
            @endforeach
        </div>

        <button type="submit">Adaugă Sală</button>
    </form>

    <a href="{{ route('sali.index') }}">Înapoi la Lista Săli</a>
</body>
</html>