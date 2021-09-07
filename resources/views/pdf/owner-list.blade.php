<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vendedores</title>
    
    <style>
    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .text-content {
        text-align: center;
        font-weight: bold;
        font-size: 11pt;
    }

    .text-title {
        text-align: center;
        font-weight: bold;
        font-size: 12pt;
        color: #000;
    }
    
    .invoice-box {
        max-width: 100%;
        margin: auto;
        font-size: 13px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .car-items table {
        border-collapse: collapse;
        width: 100%;
    }

    .car-items table td, th {
        border: 1px solid #000;
        padding: 3px;
    }

    .car-items table thead tr {
        background: #375bb5;
        color: #fff;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="car-items">
        	<div style="border: 1px solid black; border-bottom: none; text-align: center; font-size: 30px; padding: 20px; font-weight: bold;">LISTA GENERAL DE VENDEDORES</div>
            <table>
                <thead class="text-center" style="font-weight: bold;">
                    <tr>
                        <td>NOMBRE(S)</td>
                        <td>APELLIDO(S)</td>
                        <td>TELÉFONO</td>
                        <td>CI</td>
                        <td>TICKETS</td>
                        <td>REGISTRADO</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($owners as $owner)   
                        <tr style="page-break-inside: avoid;">
                            <td class="text-content">{{ $owner['names'] }}</td>
                            <td class="text-content">{{ $owner['surnames'] }}</td>
                            <td class="text-content">{{ $owner['phone'] }}</td>
                            <td class="text-content">{{ $owner['ci'] }}</td>
                            <td class="text-content">{{ $owner['tickets'] }}</td>
                            <td class="text-content">{{ $owner['created'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>