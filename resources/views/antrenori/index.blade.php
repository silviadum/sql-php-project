<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Antrenorilor</title>
</head>
<body>
    <h1>Lista Antrenorilor</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('antrenori.create') }}">Adaugă Antrenor</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Specializare</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($antrenori as $antrenor)
                <tr>
                    <td>{{ $antrenor->id_antrenor }}</td>
                    <td>{{ $antrenor->nume }}</td>
                    <td>{{ $antrenor->prenume }}</td>
                    <td>{{ $antrenor->email }}</td>
                    <td>{{ $antrenor->telefon }}</td>
                    <td>{{ $antrenor->specializare }}</td>
                    <td>
                        <a href="{{ route('antrenori.edit', $antrenor->id_antrenor) }}">Editează</a>
                        <form action="{{ route('antrenori.destroy', $antrenor->id_antrenor) }}" method="POST" style="display:inline;">
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
