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

        /* MODIFIKASI: Hapus margin-bottom */
        main {
            /* margin-bottom: 60px; -- DINONAKTIFKAN */
        }

        /* ======================================= */
        /* PERUBAHAN UTAMA: HAPUS 'position: fixed' */
        /* ======================================= */
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

        /* Tabel Utama (Tidak berubah) */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-spacing: 0;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .main-table th {
            background-color: #4A5568;
            color: #FFFFFF;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* CSS untuk header berulang kita nonaktifkan agar stabil */
        .main-table thead {
            /* display: table-header-group; -- DINONAKTIFKAN */
        }

        .main-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right !important;
        }

        /* Style Baris Total (Tidak berubah) */
        .main-table tr.total-row {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .main-table tr.total-row td {
            font-size: 11px;
        }

        .main-table tr.total-row td.terbilang {
            font-style: italic;
            font-weight: normal;
            text-align: right;
        }
    </style>
</head>
