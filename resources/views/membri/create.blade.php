<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Membru</title>
</head>
<body>
    <h1>Adaugă Membru</h1>
    <form action="{{ route('membri.store') }}" method="POST">
        @csrf
        <label>Nume:</label>
        <input type="text" name="nume" required>
        <br>
        <label>Prenume:</label>
        <input type="text" name="prenume" required>
        <br>
        <label>Data Nașterii:</label>
        <input type="date" name="data_nasterii" required> <!-- Adaugă câmpul pentru data nașterii -->
        <br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Telefon:</label>
        <input type="text" name="telefon" required>
        <br>
        <label>Parola:</label>
        <input type="password" name="parola" required>
        <br>
        <button type="submit">Adaugă</button>
    </form>
</body>
</html>
