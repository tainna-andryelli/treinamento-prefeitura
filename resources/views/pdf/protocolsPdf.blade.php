<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDF dos Protocolos</title>

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
            <h1>Protocolos</h1>
        </div>
        <table>
                <thead>
                    <tr>
                        <th>Data de criação</th>
                        <th>Descrição</th>
                        <th>Contribuinte</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($protocols as $protocol)
                        <tr>
                            <td>{{ $protocol->created_date }}</td>
                            <td>{{ $protocol->description }}</td>
                            <td>{{ $protocol->contributor_id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</body>
</html>