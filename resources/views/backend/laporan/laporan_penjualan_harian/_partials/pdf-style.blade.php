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
            margin-bottom: 60px;
        }

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

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ddd;
            /* =================================== */
            /* PERBAIKAN: Padding dikecilkan */
            /* =================================== */
            padding: 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            /* Membantu memecah teks jika terpaksa */
        }

        .main-table th {
            background-color: #4A5568;
            color: #FFFFFF;
            font-weight: bold;
            text-transform: uppercase;
        }

        .main-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right !important;
        }

        /* Tabel Detail Barang (tidak terpakai di layout ini) */
        .detail-table {
            width: 100%;
            border: none;
        }

        .detail-table td {
            border: none;
            padding: 4px 0;
        }

        /* Footer Tabel */
        .main-table tfoot tr {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .main-table tfoot td {
            font-size: 11px;
        }

        .terbilang {
            font-style: italic;
            font-weight: normal;
            text-align: right;
        }
    </style>
</head>
