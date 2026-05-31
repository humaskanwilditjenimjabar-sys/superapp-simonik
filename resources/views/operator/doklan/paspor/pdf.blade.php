<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Layanan Paspor</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .wrap {
            padding: 20mm 18mm;
        }

        /* Header */
        .header {
            background: #1E3A8A;
            color: white;
            padding: 12px 16px;
            margin-bottom: 12px;
            border-radius: 4px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header td {
            vertical-align: top;
        }

        .header h1 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .header .sub {
            font-size: 8px;
            opacity: 0.65;
        }

        .header .badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 8px;
            text-align: right;
        }

        /* Filter box */
        .filter-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 12px;
        }

        .filter-box .label {
            font-size: 7px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-bottom: 5px;
        }

        .filter-box table {
            border-collapse: collapse;
        }

        .filter-box td {
            padding: 1px 8px 1px 0;
            font-size: 8px;
            color: #475569;
        }

        .filter-box td:first-child {
            font-weight: 600;
            color: #1e3a8a;
            width: 100px;
        }

        /* Section title */
        .section-title {
            background: #1E3A8A;
            color: white;
            padding: 5px 10px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-radius: 3px 3px 0 0;
            margin-top: 12px;
        }

        /* Summary tables side by side */
        .summary-wrap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .summary-wrap td {
            vertical-align: top;
            padding: 0;
        }

        .summary-wrap td:first-child {
            padding-right: 6px;
        }

        .summary-wrap td:last-child {
            padding-left: 6px;
        }

        /* Tables */
        .tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        .tbl thead tr {
            background: #1E3A8A;
            color: white;
        }

        .tbl thead th {
            padding: 5px 8px;
            text-align: left;
            font-weight: 700;
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid #1E3A8A;
        }

        .tbl thead th.right {
            text-align: right;
        }

        .tbl tbody td {
            padding: 4px 8px;
            border: 1px solid #e2e8f0;
        }

        .tbl tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        .tbl tfoot td {
            padding: 5px 8px;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #1e3a8a;
            font-weight: 700;
            border-top: 2px solid #1e3a8a;
        }

        .tbl .right {
            text-align: right;
        }

        .tbl .center {
            text-align: center;
        }

        /* Main detail table */
        .detail-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        .detail-tbl thead tr {
            background: #1E3A8A;
            color: white;
        }

        .detail-tbl thead th {
            padding: 5px 8px;
            text-align: left;
            font-weight: 700;
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid #1a3270;
        }

        .detail-tbl tbody td {
            padding: 4px 8px;
            border: 1px solid #e2e8f0;
        }

        .detail-tbl tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        .detail-tbl tfoot td {
            padding: 5px 8px;
            background: #eff6ff;
            color: #1e3a8a;
            font-weight: 700;
            border-top: 2px solid #1e3a8a;
            border: 1px solid #bfdbfe;
        }

        .detail-tbl .center {
            text-align: center;
        }

        .detail-tbl .right {
            text-align: right;
        }

        /* Footer */
        .page-footer {
            margin-top: 12px;
            padding-top: 6px;
            border-top: 1px solid #e2e8f0;
        }

        .page-footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .page-footer td {
            font-size: 7.5px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="wrap">

        {{-- Header --}}
        <div class="header">
            <table>
                <tr>
                    <td>
                        <h1>Laporan Layanan Paspor</h1>
                        <p class="sub">{{ $kanim }}</p>
                    </td>
                    <td width="180" style="text-align:right;">
                        <div class="badge">
                            <div>Diekspor: {{ $exportedAt }}</div>
                            <div>Operator: {{ $operator }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Filter --}}
        @php
            $adaFilter =
                $filters['lokasi'] !== 'Semua Lokasi' ||
                $filters['dari'] ||
                $filters['sampai'] ||
                $filters['jenis'] !== 'Semua Jenis' ||
                $filters['search'];
        @endphp
        @if ($adaFilter)
            <div class="filter-box">
                <div class="label">Filter yang Digunakan</div>
                <table>
                    @if ($filters['lokasi'] !== 'Semua Lokasi')
                        <tr>
                            <td>Lokasi</td>
                            <td>{{ $filters['lokasi'] }}</td>
                        </tr>
                    @endif
                    @if ($filters['jenis'] !== 'Semua Jenis')
                        <tr>
                            <td>Jenis Layanan</td>
                            <td>{{ $filters['jenis'] }}</td>
                        </tr>
                    @endif
                    @if ($filters['dari'] || $filters['sampai'])
                        <tr>
                            <td>Tanggal</td>
                            <td>{{ $filters['dari'] ?? '...' }} s/d {{ $filters['sampai'] ?? '...' }}</td>
                        </tr>
                    @endif
                    @if ($filters['search'])
                        <tr>
                            <td>Pencarian</td>
                            <td>"{{ $filters['search'] }}"</td>
                        </tr>
                    @endif
                </table>
            </div>
        @endif

        {{-- Ringkasan --}}
        <div class="section-title">Ringkasan</div>
        <table class="summary-wrap">
            <tr>
                {{-- Per Lokasi --}}
                <td width="50%">
                    <table class="tbl" style="margin-top:0;border-radius:0;">
                        <thead>
                            <tr>
                                <th>Lokasi Layanan</th>
                                <th class="right">Jumlah</th>
                                <th class="right">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($summaryLokasi as $row)
                                <tr>
                                    <td>{{ $row['nama'] }}</td>
                                    <td class="right">{{ number_format($row['total']) }}</td>
                                    <td class="right">{{ $total > 0 ? round(($row['total'] / $total) * 100, 1) : 0 }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td class="right">{{ number_format($total) }}</td>
                                <td class="right">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
                {{-- Per Jenis --}}
                <td width="50%">
                    <table class="tbl" style="margin-top:0;">
                        <thead>
                            <tr>
                                <th>Jenis Layanan</th>
                                <th class="right">Jumlah</th>
                                <th class="right">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($summaryJenis as $row)
                                <tr>
                                    <td>{{ $row['nama'] }}</td>
                                    <td class="right">{{ number_format($row['total']) }}</td>
                                    <td class="right">{{ $total > 0 ? round(($row['total'] / $total) * 100, 1) : 0 }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td class="right">{{ number_format($total) }}</td>
                                <td class="right">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Data Detail --}}
        <div class="section-title">Data Detail</div>
        <table class="detail-tbl">
            <thead>
                <tr>
                    <th width="24" class="center">No</th>
                    <th width="70">Tanggal</th>
                    <th>Jenis Layanan</th>
                    <th>Lokasi</th>
                    <th width="45" class="right">Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $item)
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->jenisLayanan?->nama_layanan ?? '-' }}</td>
                        <td>{{ $item->lokasiLayanan?->nama_lokasi ?? '-' }}</td>
                        <td class="right">{{ number_format($item->jumlah) }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="right" style="font-weight:700;">Total</td>
                    <td class="right">{{ number_format($total) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        {{-- Footer --}}
        <div class="page-footer">
            <table>
                <tr>
                    <td>SIMONIK — Kanwil Ditjenim Jabar</td>
                    <td style="text-align:right;">Dicetak: {{ $exportedAt }}</td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
