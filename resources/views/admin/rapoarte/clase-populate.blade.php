<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase Populate</title>
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
        .editable {
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Clase Populate</h1>
        <table>
            <thead>
                <tr>
                    <th>Denumire Clasă</th>
                    <th>Antrenor</th>
                    <th>Sala</th>
                    <th>Capacitate</th>
                    <th>Număr Membri</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clase as $clasa)
                    <tr>
                        <td class="editable" data-name="denumire_clasa" data-id="{{ $clasa->id_clasa }}">{{ $clasa->denumire_clasa }}</td>
                        <td>{{ $clasa->antrenor }}</td>
                        <td>{{ $clasa->denumire_sala }}</td>
                        <td class="editable" data-name="capacitate" data-id="{{ $clasa->id_clasa }}">{{ $clasa->capacitate }}</td>
                        <td>{{ $clasa->numar_membri }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('.editable').click(function() {
                var $this = $(this);
                var originalValue = $this.text();
                var name = $this.data('name');
                var id = $this.data('id');
                var input = $('<input>', {
                    type: 'text',
                    value: originalValue,
                    blur: function() {
                        var newValue = $(this).val();
                        if (newValue !== originalValue) {
                            $.ajax({
                                url: '{{ route("clase-populate.update") }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_clasa: id,
                                    [name]: newValue
                                },
                                success: function(response) {
                                    $this.text(newValue);
                                    alert(response.success);
                                }
                            });
                        } else {
                            $this.text(originalValue);
                        }
                    },
                    keyup: function(e) {
                        if (e.which === 13) {
                            $(this).blur();
                        }
                    }
                }).appendTo($this.empty()).focus();
            });
        });
    </script>
</body>
</html>