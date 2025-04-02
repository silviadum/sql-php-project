<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Antrenor</title>
</head>
<body>
    <h1>Adaugă Antrenor</h1>

    <!-- Afișare mesaje de succes sau eroare -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Formular pentru adăugarea unui antrenor -->
    <form action="{{ route('antrenori.store') }}" method="POST">
        @csrf
        <label>Nume:</label>
        <input type="text" name="nume" required>
        <br>
        <label>Prenume:</label>
        <input type="text" name="prenume" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Telefon:</label>
        <input type="text" name="telefon" required>
        <br>
        <label>Specializare:</label>
        <input type="text" name="specializare" required>
        <br>
        <button type="submit">Adaugă</button>
    </form>

    <!-- Link pentru a reveni la lista antrenorilor -->
    <a href="{{ route('antrenori.index') }}">Înapoi la lista antrenorilor</a>
</body>
</html>
