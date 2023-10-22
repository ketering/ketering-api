<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faktura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .header {
            top: 0;
            left: 0;
            width: 50%;
            margin-top: 1rem;
        }

        .logo {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            text-align: right;
            margin-top: 1rem;
        }

        th {
            background-color: lightslategrey;
        }

        th, td {
            font-size: 11pt;
            border: 1px solid black;
            padding: 5px;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        .fancy-title {
            border: 1px solid black;
            background-color: lightslategrey;
            font-weight: bold;
            padding: 5px;
            width: 30%;
            margin-bottom: 10px;
        }

        .content {
            margin-top: 4rem;
        }

        .qr-code {
            text-align: center;
            margin-top: 4rem;
        }

        .message {
            text-align: center;
            margin-top: 4rem;
        }

        /* Custom table styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Custom table header styles */
        .custom-thead {
            background-color: lightslategrey;
        }

        .custom-thead th {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="d-flex flex-column">
        <div style="margin-bottom: 20px">
            <img width="200" src="{{asset('munch.png')}}" alt="">
        </div>
        <div>
            <div>Ulica 1. maj</div>
            <div>Podgorica, 81400</div>
            <div>Telefon: 382 69 65 65 65</div>
            <div>Žiro racun: 535-14154-50</div>
        </div>
    </div>
</div>
<div class="logo">
    <h1>Racun za ketering</h1>
    <table>
        <thead class="custom-thead">
        <tr>
            <th>Racun broj #</th>
            <th>Period</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="text-align: center"></td>
            <td style="text-align: center">{{ $dateRange }}</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="content" style="margin-top: 4rem;">
    <div class="fancy-title d-inline ps-1 pe-5">Komitent/Kupac</div>
    <div class="ps-1 mt-4">
        <div>Mladen Kandic</div>
        <div>ICT Cortex</div>
        <div>Ulica 13. jul</div>
        <div>Podgorica, 81400</div>
        <div>382 67 645 445</div>
        <div>info@ictcortex.me</div>
    </div>
</div>
<div class="content">
    <table>
        <thead class="custom-thead">
        <tr>
            <th colspan="3">Opis</th>
            <th style="text-align: right">Iznos €</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="3">
                <ul class="ps-3">
                    @foreach($orders as $order)
                        <li>Ketering za {{ $order->user->name }} {{ $order->user->surname }}
                            za {{ $order->forDate }}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <ul style="text-align: right">
                    @foreach($orders as $order)
                        <li>{{ $order->totalPrice }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <td class="text-center align-items-center" style="width: 60%;">
                <b><em>Hvala puno što koristite naše usluge</em></b>
            </td>
            <td colspan="3" style="position:relative;">
                <b>Ukupno</b>
                <b style="position: absolute; right: 10px">€ {{ $orders->sum('totalPrice') }}</b>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="qr-code">
    <img height="120" src="{{asset('ictcortexqr.png')}}" alt="">
</div>
<div class="message">
    <b>Ukoliko imate pitanja kontaktirajte nas putem email adrese:</b>
    <div>
        <a href="mailto:munchketering@gmail.com">
            <b>munchketering@gmail.com</b>
        </a>
    </div>
</div>
</body>
</html>
