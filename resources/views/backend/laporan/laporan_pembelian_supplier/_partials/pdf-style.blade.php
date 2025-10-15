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

        /* Tabel Utama */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        .main-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
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
    </style>
</head>
