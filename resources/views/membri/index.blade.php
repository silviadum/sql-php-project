<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Membrilor</title>
</head>
<body>
    <h1>Lista Membrilor</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('membri.create') }}">Adaugă Membru</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($membri as $membru)
                <tr>
                    <td>{{ $membru->id_membru }}</td>
                    <td>{{ $membru->nume }}</td>
                    <td>{{ $membru->prenume }}</td>
                    <td>{{ $membru->email }}</td>
                    <td>{{ $membru->telefon }}</td>
                    <td>
                        <a href="{{ route('membri.edit', $membru->id_membru) }}">Editează</a>
                        <form action="{{ route('membri.destroy', $membru->id_membru) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Șterge</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
