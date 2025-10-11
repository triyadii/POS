<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Laba Rugi</h1>
            {{-- Ganti dengan nama usaha Anda --}}
            <p><strong>DISKON BESAR 22</strong></p>
            <p>Periode: {{ \Carbon\Carbon::parse($start)->format('d F Y') }} -
                {{ \Carbon\Carbon::parse($end)->format('d F Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th class="text-right">Pendapatan</th>
                    <th class="text-right">Pengeluaran (HPP)</th>
                    <th class="text-right">Laba Bersih</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPendapatan = 0;
                    $totalPengeluaran = 0;
                    $totalLaba = 0;
                @endphp
                @forelse ($periode as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}</td>
                        <td class="text-right">Rp {{ number_format($item['total_pendapatan'], 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item['laba_bersih'], 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalPendapatan += $item['total_pendapatan'];
                        $totalPengeluaran += $item['pengeluaran'];
                        $totalLaba += $item['laba_bersih'];
                    @endphp
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada data pada rentang tanggal ini.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalLaba, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
