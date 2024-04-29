<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDF do Protocolo</title>

  <style>
    body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .container {
            width: 600px;
            margin: 0 auto;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
        }
        thead th, tbody td {
            border: 1px solid #ddd; 
            padding: 8px; 
        }
        thead {
            background-color: #f2f2f2; 
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9; 
        }
        th, td {
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
  </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>Protocolo Nº {{ $protocol->number }}</h1>
        </div>
        <div class="info">
            <p><strong>Número do Protocolo:</strong> {{ $protocol->number }}</p>
            <p><strong>Data e hora de Criação:</strong> {{ $protocol->created_at }}</p>
            <p><strong>Descrição:</strong> {{ $protocol->description }}</p>
            <p><strong>Contribuinte:</strong> {{ $contributor->name }}</p>
        </div>

        <div>
            <h2>Acompanhamentos:</h2>
            <table>
                <thead>
                    <tr>
                        <th>Data e Hora</th>
                        <th>Descrição</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accompaniments as $accompaniment)
                        <tr>
                            <td>{{ $accompaniment->created_at }}</td>
                            <td>{{ $accompaniment->description }}</td>
                            <td>{{ $accompaniment->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>