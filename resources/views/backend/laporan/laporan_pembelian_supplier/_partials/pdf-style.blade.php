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

        .section-title {
            font-size: 14px;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        /* Statistik */
        .stats-container {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
        }

        .stat-box {
            display: table-cell;
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .stat-box .value {
            font-size: 18px;
            font-weight: bold;
        }

        .stat-box .label {
            font-size: 12px;
            color: #666;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ddd;
            /* Border lebih soft */
            padding: 8px;
            /* Padding lebih besar */
            text-align: left;
            vertical-align: top;
        }

        .main-table th {
            background-color: #4A5568;
            /* Header lebih gelap */
            color: #FFFFFF;
            /* Teks header putih */
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Zebra-striping untuk baris agar mudah dibaca */
        .main-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right !important;
        }

        /* Tabel Detail Barang */
        .detail-table {
            width: 100%;
            margin-top: 5px;
        }

        .detail-table td {
            border: none;
            padding: 2px 0;
        }

        .detail-item {
            border-bottom: 1px dashed #eee;
            padding-bottom: 3px;
            margin-bottom: 3px;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .total-row strong {
            font-size: 12px;
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
    </style>
</head>
