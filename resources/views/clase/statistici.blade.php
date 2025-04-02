<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistici Clase</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .grad-ocupare-ridicat {
            color: red;
        }
        .grad-ocupare-mediu {
            color: orange;
        }
        .grad-ocupare-scazut {
            color: green;
        }
        .delete-btn {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #dc2626;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Statistici Clase</h1>
        <table>
            <thead>
                <tr>
                    <th>Denumire Clasă</th>
                    <th>Antrenor</th>
                    <th>Sala</th>
                    <th>Capacitate</th>
                    <th>Membri Înscriși</th>
                    <th>Grad Ocupare</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistici as $stat)
                    <tr id="clasa-{{ $stat->id_clasa }}">
                        <td>{{ $stat->denumire_clasa }}</td>
                        <td>{{ $stat->antrenor_nume }} {{ $stat->antrenor_prenume }}</td>
                        <td>{{ $stat->denumire_sala }}</td>
                        <td>{{ $stat->capacitate }}</td>
                        <td>{{ $stat->membri_inscrisi }}</td>
                        <td class="@if($stat->grad_ocupare >= 80) grad-ocupare-ridicat 
                                   @elseif($stat->grad_ocupare >= 50) grad-ocupare-mediu
                                   @else grad-ocupare-scazut @endif">
                            {{ $stat->grad_ocupare }}%
                        </td>
                        <td>
                            <button class="delete-btn" data-id="{{ $stat->id_clasa }}">Șterge</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="legenda" style="margin-top: 20px;">
            <p><span style="color: red;">■</span> Grad ocupare ridicat (≥80%)</p>
            <p><span style="color: orange;">■</span> Grad ocupare mediu (50-79%)</p>
            <p><span style="color: green;">■</span> Grad ocupare scăzut (<50%)</p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                if (confirm('Ești sigur că vrei să ștergi această clasă?')) {
                    $.ajax({
                        url: '{{ route("clase.delete") }}',
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_clasa: id
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#clasa-' + id).remove();
                                alert(response.success);
                            } else {
                                alert('A apărut o eroare la ștergerea clasei.');
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>