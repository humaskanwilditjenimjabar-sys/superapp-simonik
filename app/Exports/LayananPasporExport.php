<?php

namespace App\Exports;

use App\Modules\Doklan\Models\LayananPaspor;
use App\Models\LokasiLayanan;
use App\Models\JenisLayanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class LayananPasporExport implements FromCollection, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected array $sectionRows = [];

    public function __construct(
        protected int $operatorId,
        protected int $kanimId,
        protected ?int $filterLokasi,
        protected string $filterDari,
        protected string $filterSampai,
        protected string $filterJenis,
        protected string $search,
    ) {}

    public function title(): string { return 'Layanan Paspor'; }

    public function collection(): Collection
    {
        $rows = collect();

        // ── Judul ──
        $rows->push(['LAPORAN LAYANAN PASPOR', '', '', '']);
        $rows->push([auth()->user()->kanim?->nama_kanim ?? '-', '', '', '']);
        $rows->push(['Diekspor: ' . now()->format('d/m/Y H:i') . ' WIB · Operator: ' . auth()->user()->nama_lengkap, '', '', '']);
        $rows->push(['', '', '', '']);

        // ── Filter aktif ──
        $adaFilter = $this->filterLokasi || $this->filterDari || $this->filterSampai || $this->filterJenis || $this->search;
        if ($adaFilter) {
            $this->sectionRows['filter_header'] = $rows->count() + 1;
            $rows->push(['FILTER YANG DIGUNAKAN', '', '', '']);
            if ($this->filterLokasi) {
                $lokasi = LokasiLayanan::find($this->filterLokasi);
                $rows->push(['Lokasi', $lokasi?->nama_lokasi ?? '-', '', '']);
            }
            if ($this->filterDari && $this->filterSampai) {
                $rows->push(['Tanggal', Carbon::parse($this->filterDari)->format('d/m/Y') . ' s/d ' . Carbon::parse($this->filterSampai)->format('d/m/Y'), '', '']);
            } elseif ($this->filterDari) {
                $rows->push(['Dari Tanggal', Carbon::parse($this->filterDari)->format('d/m/Y'), '', '']);
            } elseif ($this->filterSampai) {
                $rows->push(['Sampai Tanggal', Carbon::parse($this->filterSampai)->format('d/m/Y'), '', '']);
            }
            if ($this->filterJenis) {
                $jenis = JenisLayanan::find($this->filterJenis);
                $rows->push(['Jenis Layanan', $jenis?->nama_layanan ?? '-', '', '']);
            }
            if ($this->search) {
                $rows->push(['Pencarian', $this->search, '', '']);
            }
            $rows->push(['', '', '', '']);
        }

        // ── Ambil data ──
        $data = LayananPaspor::with(['jenisLayanan', 'lokasiLayanan'])
            ->where('operator_id', $this->operatorId)
            ->when($this->filterLokasi, fn($q) => $q->where('lokasi_layanan_id', $this->filterLokasi))
            ->when($this->filterDari,   fn($q) => $q->where('tanggal', '>=', $this->filterDari))
            ->when($this->filterSampai, fn($q) => $q->where('tanggal', '<=', $this->filterSampai))
            ->when($this->filterJenis,  fn($q) => $q->where('jenis_layanan_id', $this->filterJenis))
            ->when($this->search, fn($q) => $q->where(function($sq) {
                $sq->whereHas('jenisLayanan',   fn($jq) => $jq->where('nama_layanan', 'like', '%'.$this->search.'%'))
                   ->orWhereHas('lokasiLayanan', fn($lq) => $lq->where('nama_lokasi',  'like', '%'.$this->search.'%'))
                   ->orWhere('keterangan', 'like', '%'.$this->search.'%');
            }))
            ->orderBy('tanggal', 'desc')
            ->get();

        $total = $data->sum('jumlah');

        // ── Ringkasan Per Lokasi ──
        $this->sectionRows['lokasi_header'] = $rows->count() + 1;
        $rows->push(['RINGKASAN PER LOKASI', '', '']);
        $this->sectionRows['lokasi_thead'] = $rows->count() + 1;
        $rows->push(['Lokasi Layanan', 'Jumlah', '%']);
        foreach ($data->groupBy('lokasi_layanan_id') as $items) {
            $t = $items->sum('jumlah');
            $rows->push([
                $items->first()->lokasiLayanan?->nama_lokasi ?? '-',
                $t,
                $total > 0 ? round($t / $total * 100, 1) . '%' : '0%',
            ]);
        }
        $this->sectionRows['lokasi_total'] = $rows->count() + 1;
        $rows->push(['Total', $total, '100%']);
        $rows->push(['', '', '']);

        // ── Ringkasan Per Jenis ──
        $this->sectionRows['jenis_header'] = $rows->count() + 1;
        $rows->push(['RINGKASAN PER JENIS LAYANAN', '', '']);
        $this->sectionRows['jenis_thead'] = $rows->count() + 1;
        $rows->push(['Jenis Layanan', 'Jumlah', '%']);
        foreach ($data->groupBy('jenis_layanan_id') as $items) {
            $t = $items->sum('jumlah');
            $rows->push([
                $items->first()->jenisLayanan?->nama_layanan ?? '-',
                $t,
                $total > 0 ? round($t / $total * 100, 1) . '%' : '0%',
            ]);
        }
        $this->sectionRows['jenis_total'] = $rows->count() + 1;
        $rows->push(['Total', $total, '100%']);
        $rows->push(['', '', '']);

        // ── Data Detail ──
        $this->sectionRows['detail_header'] = $rows->count() + 1;
        $rows->push(['DATA DETAIL', '', '', '', '', '']);
        $this->sectionRows['detail_thead'] = $rows->count() + 1;
        $rows->push(['No', 'Tanggal', 'Jenis Layanan', 'Lokasi Layanan', 'Jumlah', 'Keterangan']);
        $this->sectionRows['detail_data_start'] = $rows->count() + 1;

        $no = 1;
        foreach ($data as $item) {
            $rows->push([
                $no++,
                Carbon::parse($item->tanggal)->format('d/m/Y'),
                $item->jenisLayanan?->nama_layanan  ?? '-',
                $item->lokasiLayanan?->nama_lokasi  ?? '-',
                $item->jumlah,
                $item->keterangan ?? '-',
            ]);
        }

        $this->sectionRows['detail_total'] = $rows->count() + 1;
        $rows->push(['', '', '', 'TOTAL', $total, '']);

        return $rows;
    }

    public function styles(Worksheet $sheet): array { return []; }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $s = $this->sectionRows;

                // ── Judul ──
                $sheet->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1E3A8A']]]);
                $sheet->getStyle('A2:A3')->applyFromArray(['font' => ['size' => 10, 'color' => ['rgb' => '64748B']]]);

                // ── Helper: section header style (navy, full width cols) ──
                $navyStyle = [
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                ];
                $theadStyle = [
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '334E88']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
                ];
                $totalStyle = [
                    'font' => ['bold' => true, 'color' => ['rgb' => '1E3A8A']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFF6FF']],
                    'borders' => ['top' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '1E3A8A']]],
                ];
                $dataStyle = [
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']]],
                ];

                // ── Filter ──
                if (isset($s['filter_header'])) {
                    $sheet->getStyle('A' . $s['filter_header'] . ':B' . $s['filter_header'])->applyFromArray($navyStyle);
                }

                // ── Ringkasan Lokasi ──
                $sheet->getStyle('A' . $s['lokasi_header'] . ':C' . $s['lokasi_header'])->applyFromArray($navyStyle);
                $sheet->getStyle('A' . $s['lokasi_thead'] . ':C' . $s['lokasi_thead'])->applyFromArray($theadStyle);
                // data rows lokasi
                $lokasiDataStart = $s['lokasi_thead'] + 1;
                $lokasiDataEnd   = $s['lokasi_total'] - 1;
                if ($lokasiDataEnd >= $lokasiDataStart) {
                    $sheet->getStyle("A{$lokasiDataStart}:C{$lokasiDataEnd}")->applyFromArray($dataStyle);
                    for ($r = $lokasiDataStart; $r <= $lokasiDataEnd; $r++) {
                        if ($r % 2 === 0) {
                            $sheet->getStyle("A{$r}:C{$r}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
                        }
                    }
                }
                $sheet->getStyle('A' . $s['lokasi_total'] . ':C' . $s['lokasi_total'])->applyFromArray($totalStyle);
                $sheet->getStyle('B' . $s['lokasi_thead'] . ':C' . $s['lokasi_total'])->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // ── Ringkasan Jenis ──
                $sheet->getStyle('A' . $s['jenis_header'] . ':C' . $s['jenis_header'])->applyFromArray($navyStyle);
                $sheet->getStyle('A' . $s['jenis_thead'] . ':C' . $s['jenis_thead'])->applyFromArray($theadStyle);
                $jenisDataStart = $s['jenis_thead'] + 1;
                $jenisDataEnd   = $s['jenis_total'] - 1;
                if ($jenisDataEnd >= $jenisDataStart) {
                    $sheet->getStyle("A{$jenisDataStart}:C{$jenisDataEnd}")->applyFromArray($dataStyle);
                    for ($r = $jenisDataStart; $r <= $jenisDataEnd; $r++) {
                        if ($r % 2 === 0) {
                            $sheet->getStyle("A{$r}:C{$r}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
                        }
                    }
                }
                $sheet->getStyle('A' . $s['jenis_total'] . ':C' . $s['jenis_total'])->applyFromArray($totalStyle);
                $sheet->getStyle('B' . $s['jenis_thead'] . ':C' . $s['jenis_total'])->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // ── Data Detail ──
                $sheet->getStyle('A' . $s['detail_header'] . ':F' . $s['detail_header'])->applyFromArray($navyStyle);
                $sheet->getStyle('A' . $s['detail_thead'] . ':F' . $s['detail_thead'])->applyFromArray($theadStyle);
                $detailDataEnd = $s['detail_total'] - 1;
                if ($detailDataEnd >= $s['detail_data_start']) {
                    $sheet->getStyle('A' . $s['detail_data_start'] . ':F' . $detailDataEnd)->applyFromArray($dataStyle);
                    for ($r = $s['detail_data_start']; $r <= $detailDataEnd; $r++) {
                        if ($r % 2 === 0) {
                            $sheet->getStyle("A{$r}:F{$r}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
                        }
                    }
                    $sheet->getStyle('A' . $s['detail_data_start'] . ':A' . $detailDataEnd)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E' . $s['detail_data_start'] . ':E' . $detailDataEnd)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                $sheet->getStyle('A' . $s['detail_total'] . ':F' . $s['detail_total'])->applyFromArray($totalStyle);
                $sheet->getStyle('E' . $s['detail_total'])->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // ── Column widths ──
                $sheet->getColumnDimension('A')->setWidth(6);
                $sheet->getColumnDimension('B')->setWidth(16);
                $sheet->getColumnDimension('C')->setWidth(28);
                $sheet->getColumnDimension('D')->setWidth(28);
                $sheet->getColumnDimension('E')->setWidth(10);
                $sheet->getColumnDimension('F')->setWidth(30);
            },
        ];
    }
}