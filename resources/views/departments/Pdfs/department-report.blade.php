<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport du Département</title>
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
            width: 150px;
            height: auto;
            margin: 0 auto 15px;
            display: block;
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
        .section-title {
            font-size: 13pt;
            font-weight: bold;
            margin: 25px 0 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
        }
        .department-info {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #000;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .department-info h3 {
            margin: 5px 0;
            font-size: 12pt;
        }
        .department-info p {
            margin: 3px 0;
            font-size: 11pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11pt;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #eaeaea;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
        .empty-message {
            text-align: center;
            font-style: italic;
            color: #666;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 8px;
            font-size: 10pt;
            color: #444;
            position: fixed;
            bottom: 1cm;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 24px; font-weight: bold; color: #003366;">CMCI</div>
            <div style="font-size: 16px; color: #666;">Communaute Missionnaire Chrétien International</div>
        </div>
        <h1>RAPPORT DU DÉPARTEMENT</h1>
        <p>Téléchargé le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- INFORMATIONS DU DÉPARTEMENT -->
    <div class="department-info">
        <h3>Nom du Département : {{ $department->name }}</h3>
        <h3>Chef de département : {{$department->head->name}}</h3>
        <h3>Contact du Chef de Departement : {{ $department->head->phone ?? 'Non renseigné' }}</h3>
    </div>

    <!-- SECTION OUVRIERS -->
    <h2 class="section-title">Ouvriers par Service</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Service</th>
                <th style="width: 25%;">Nom et Prénom</th>
                <th style="width: 20%;">Poste</th>
                <th style="width: 15%;">Matricule</th>
                <th style="width: 20%;">Téléphone</th>
            </tr>
        </thead>
        <tbody>
            @php $currentService = ''; @endphp
            @foreach($department->services->sortBy('name') as $service)
                @forelse($service->users->sortBy('name') as $user)
                    <tr>
                        @if($currentService !== $service->name)
                            <td rowspan="{{ $service->users->count() }}" style="text-align:center; font-weight:bold;">
                                {{ $service->name }}
                            </td>
                            @php $currentService = $service->name; @endphp
                        @endif
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->roles->first()->name ?? 'Non assigné' }}</td>
                        <td>{{ $user->matricule }}</td>
                        <td>{{ $user->phone ?? 'Non renseigné' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td colspan="4" class="empty-message">Aucun personnel affecté à ce service</td>
                    </tr>
                @endforelse
            @endforeach
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Document confidentiel - {{ config('app.name') }}</p>
        <p>Page 1/1</p>
    </div>
</body>
</html>
