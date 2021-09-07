<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mis Tickets</title>
    
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
        /* padding: 30px; */
        /* border: 2px solid #000; */
        /* box-shadow: 0 0 10px rgba(0, 0, 0, .15); */
        font-size: 13px;
        /* line-height: 24px; */
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
        	<div style="border: 1px solid black; border-bottom: none; text-align: center; font-size: 30px; padding: 20px; font-weight: bold;">MIS TICKETS</div>
            <table>
                <thead class="text-center" style="font-weight: bold;">
                    <tr>
                        <td>Nº</td>
                        <td>CÓD BATERÍA</td>
                        <td>ESTADO</td>
                        <td>CLIENTE</td>
                        <td>REGISTRADO</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)   
	                    <tr style="page-break-inside: avoid;">
	                        <td class="text-content">{{ substr($ticket['uuid'], 0, 8) }}</td>
	                        <td class="text-content">{{ $ticket['battery_code'] }}</td>
	                        <td class="text-content">{{ $ticket['status'] === 1 ? 'Pendiente' : 'Canjeado' }}</td>
	                        <td class="text-content">{{ $ticket['customer']['names'] }} {{ $ticket['customer']['surnames'] }}</td>
	                        <td class="text-content">{{ date('d/m/Y', strtotime($ticket['created_at'])) }}</td>
	                    </tr>
	                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>