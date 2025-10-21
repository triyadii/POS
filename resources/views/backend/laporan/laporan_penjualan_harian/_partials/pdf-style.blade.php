<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #222;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        main {
            /* (margin-bottom: 60px; -- DINONAKTIFKAN) */
        }

        /* Footer "Dicetak Oleh" (Sudah benar, tidak fixed) */
        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 50px;
            font-size: 9px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .footer-left {
            float: left;
            width: 50%;
            text-align: left;
        }

        .footer-right {
            float: right;
            width: 50%;
            text-align: right;
            color: #888;
        }

        /* ======================================= */
        /* STYLE BARU UNTUK STRUKTUR PDF BARU */
        /* ======================================= */

        /* Style untuk tabel header transaksi */
        .transaction-header {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: #f2f2f2;
            font-size: 11px;
            border: 1px solid #ccc;
        }

        .transaction-header td {
            border: none;
            padding: 8px;
            vertical-align: top;
            word-wrap: break-word;
        }

        /* Style untuk tabel detail item */
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            /* Jarak antar transaksi */
        }

        .item-table th,
        .item-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        .item-table th {
            background-color: #4A5568;
            color: #FFFFFF;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        .item-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* ======================================= */
        /* AKHIR STYLE BARU */
        /* ======================================= */


        .text-right {
            text-align: right !important;
        }

        .terbilang {
            font-style: italic;
            font-weight: normal;
            text-align: right;
        }
    </style>
</head>
