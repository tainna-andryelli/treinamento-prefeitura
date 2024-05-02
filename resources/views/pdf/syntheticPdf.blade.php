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
            width: 650px;
            margin: 0 auto;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 16px;
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
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fd/Bras%C3%A3o_de_S%C3%A3o_Leopoldo_-_RS.svg" alt="Logo Prefeitura São Leopoldo" style="width: 50px; height: auto;">
            <p style="font-size: 12px; text-transform: uppercase;">Prefeitura Municipal de São Leopoldo</p>
            <span style="font-size: 12px; text-transform: uppercase;">Estado do Rio Grande do Sul</span>
        </div>

        <div>
            <h2 class="title">Relatório de protocolos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Contribuinte</th>
                        <th>Dt Abertura</th>
                        <th>Dt Limite</th>
                        <th>Situação</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($protocols as $protocol)
                    <tr>
                        <td>{{ $protocol->number }}</td>
                        <td>
                            <?php
                                $contributor = $people->firstWhere('id', $protocol->contributor_id);
                                echo $contributor ? $contributor->name : '';
                            ?>
                        </td>
                        <td>{{ date('d/m/Y', strtotime($protocol->created_date)) }}</td>
                        <td>
                            <?php
                                $createdDate = \Carbon\Carbon::parse($protocol->created_date);
                                $deadlineDate = $createdDate->addDays($protocol->deadline_days)->format('d/m/Y');
                                echo $deadlineDate;
                            ?>  
                        </td>
                        <td>    @if($protocol->status === 'A')
                                    {{ 'Aberto' }}
                                @elseif($protocol->status === 'E')
                                    {{ 'Em atendimento' }}
                                @elseif($protocol->status === 'S')
                                    {{ 'Solucionado' }}
                                @endif</td>
                        <td>{{ $protocol->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>