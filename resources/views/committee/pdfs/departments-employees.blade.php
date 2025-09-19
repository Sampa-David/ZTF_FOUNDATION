<!D    <meta charset="utf-8">
    <title>Liste des Ouvriers par Departements</title>
    <style>
        /* Reset et configuration de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: white;
        }

        /* En-tête avec logos */
        .header {
            position: relative;
            padding: 20px 0;
            border-bottom: 3px solid #1e88e5;
            margin-bottom: 30px;
        }

        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .titles {
            text-align: center;
            flex: 1;
            padding: 0 20px;
        }

        .titles h1 {
            font-size: 16px;
            font-weight: bold;
            color: #1e88e5;
            margin: 0;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            font-size: 20px;
            color: #1e88e5;
            margin: 15px 0 10px;
        }

        .header p {
            text-align: center;
            color: #666;
            font-size: 12px;
        }

        /* Section département */
        .department-section {
            margin-bottom: 25px;
            break-inside: avoid;
        }

        .department-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            color: #1e88e5;
            font-size: 16px;
            font-weight: bold;
            border-left: 4px solid #1e88e5;
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }

        th {
            background-color: #1e88e5;
            color: white;
            padding: 12px 8px;
            font-size: 14px;
            font-weight: normal;
            text-align: left;
            border: 1px solid #1e88e5;
        }

        td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 13px;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        /* Pied de page */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #1e88e5;
            font-size: 12px;
            color: #666;
            position: running(footer);
        }

        /* Styles pour l'impression */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .header {
                position: running(header);
            }

            @page {
                @top-center {
                    content: element(header);
                }
                @bottom-center {
                    content: element(footer);
                }
            }

            .department-section {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            table {
                break-inside: auto;
            }

            tr {
                break-inside: avoid;
                break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }

        /* Styles responsive */
        @media screen and (max-width: 768px) {
            .logo-container {
                flex-direction: column;
                gap: 15px;
            }

            .titles h1 {
                font-size: 14px;
            }

            h2 {
                font-size: 18px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 6px;
            }
        }
    </style>
</head>PE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des Ouvriers par Departements</title>  
    <link rel="stylesheet" href="{{asset('css/pdfs.css')}}">
</head>
<body>
    <div class="header">
        
            <div class="titles">
                <h1>COMMUNAUTE MISSIONNAIRE CHRETIENNE INTERNATIONALE</h1>
                <h1>CHRISTIAN MISSIONARY FELLOWSHIP INTERNATIONAL</h1>
            </div>
        
        <h2>LISTE DES DÉPARTEMENTS ET OUVRIERS</h2>
        <p>Document généré le {{ now()->format('d/m/Y à H:i:s') }}</p>
    </div>

    @foreach($departments as $department)
        <div class="department-section">
            <div class="department-header">
                Département : {{ $department->name }}
            </div>
            <table>
                <thead>
                    <tr>
                                <th width="5%">N°</th>
                        <th width="30%">Nom de l'employé</th>
                        <th width="15%">Matricule</th>
                        <th width="25%">Service</th>
                        <th width="25%">Poste</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($department->services as $service)
                        @foreach($service->users as $index => $employee)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->matricule }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $employee->roles->first()->role_name ?? 'Non assigné' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        <p>Document confidentiel - {{ config('app.name') }}</p>
        <p>Page {PAGENO}/{nbpg}</p>
    </div>
</body>
</html>