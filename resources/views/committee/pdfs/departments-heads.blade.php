<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des Départements et Chefs</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.4;
            margin: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            width: 150px;
            height: auto;
            margin: 0 auto 15px;
            display: block;
            object-fit: contain;
        }
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 11pt;
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11pt;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10pt;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($logoBase64)
            <img src="data:image/png;base64,{{ $logoBase64 }}" class="logo" alt="CMCI Logo">
        @endif
        <h1>LISTE DES DÉPARTEMENTS ET CHEFS</h1>
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">N°</th>
                <th style="width: 40%;">Département</th>
                <th style="width: 50%;">Chef de Département</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $index => $department)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->head->name ?? 'Non assigné' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Document confidentiel - {{ config('app.name') }}</p>
        <p>Page 1/1</p>
    </div>
</body>
</html>