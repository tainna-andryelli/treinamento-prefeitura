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
            width: 650px;
            margin: 0 auto;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 16px;
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
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fd/Bras%C3%A3o_de_S%C3%A3o_Leopoldo_-_RS.svg" alt="Logo Prefeitura São Leopoldo" style="width: 50px; height: auto;">
            <p style="font-size: 12px; text-transform: uppercase;">Prefeitura Municipal de São Leopoldo</p>
            <span style="font-size: 12px; text-transform: uppercase;">Estado do Rio Grande do Sul</span>
        </div>

        <div style="margin-bottom: 20px;">
            <h2 class="title">Relatório detalhado de protocolo</h2>
            <table>
                <tbody>
                    <tr>
                        <td><strong>Número:</strong> {{ $protocol->number }}</td>
                        <td><strong>Data e hora de Abertura:</strong> {{ date('d/m/Y H:i:s', strtotime($protocol->created_at)) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Contribuinte:</strong> {{ $contributor->name }}</td>
                        <td><strong>Data Limite:</strong> {{ date('d/m/Y', strtotime($deadline_date)) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Departamento:</strong> {{ $department->name }}</td>
                        <td><strong>Situação:</strong> {{ $status }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Descrição:</strong> {{ $protocol->description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-bottom: 20px;">
            <h2 class="title">Acompanhamentos:</h2>
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
                            <td>{{ date('d/m/Y H:i:s', strtotime($accompaniment->created_at)) }}</td>
                            <td>{{ $accompaniment->description }}</td>
                            <td>
                                @if($accompaniment->status === 'A')
                                    {{ 'Aberto' }}
                                @elseif($accompaniment->status === 'E')
                                    {{ 'Em atendimento' }}
                                @elseif($accompaniment->status === 'S')
                                    {{ 'Solucionado' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>