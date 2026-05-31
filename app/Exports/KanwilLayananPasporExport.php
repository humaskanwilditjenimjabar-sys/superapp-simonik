<?php

namespace App\Exports;

use App\Modules\Doklan\Models\LayananPaspor;
use App\Models\JenisLayanan;
use App\Models\KantorImigrasi;
use App\Models\LokasiLayanan;
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

class KanwilLayananPasporExport implements FromCollection, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected array $sectionRows = [];

    public function __construct(
        protected int  $kanwilId,
        protected ?int $filterKanim,
        protected ?int $filterLokasi,
        protected string $filterDari,
        protected string $filterSampai,
        protected string $filterJenis,
    ) {}

    public function title(): string { return 'Layanan Paspor'; }

    public function collection(): Collection
    {
        $rows = collect();

        // ── Judul ──
        $rows->push(['LAPORAN LAYANAN PASPOR - KANWIL', '', '', '', '', '']);
        $rows->push(['Kantor Wilayah Direktorat Jenderal Imigrasi Jawa Barat', '', '', '', '', '']);
        $rows->push(['Diekspor: ' . now()->format('d/m/Y H:i') . ' WIB · Oleh: ' . auth()->user()->nama_lengkap, '', '', '', '', '']);
        $rows->push(['', '', '', '', '', '']);

        // ── Filter aktif ──
        $adaFilter = $this->filterKanim || $this->filterLokasi || $this->filterDari || $this->filterSampai || $this->filterJenis;
        if ($adaFilter) {
            $this->sectionRows['filter_header'] = $rows->count() + 1;
            $rows->push(['FILTER YANG DIGUNAKAN', '', '', '', '', '']);
            if ($this->filterKanim) {
                $kanim = KantorImigrasi::find($this->filterKanim);
                $rows->push(['Kantor Imigrasi', $kanim?->nama_kanim ?? '-', '', '', '', '']);
            }
            if ($this->filterLokasi) {
                $lokasi = LokasiLayanan::find($this->filterLokasi);
                $rows->push(['Lokasi', $lokasi?->nama_lokasi ?? '-', '', '', '', '']);
            }
            if ($this->filterDari && $this->filterSampai) {
                $rows->push(['Tanggal', Carbon::parse($this->filterDari)->format('d/m/Y') . ' s/d ' . Carbon::parse($this->filterSampai)->format('d/m/Y'), '', '', '', '']);
            } elseif ($this->filterDari) {
                $rows->push(['Dari Tanggal', Carbon::parse($this->filterDari)->format('d/m/Y'), '', '', '', '']);
            } elseif ($this->filterSampai) {
                $rows->push(['Sampai Tanggal', Carbon::parse($this->filterSampai)->format('d/m/Y'), '', '', '', '']);
            }
            if ($this->filterJenis) {
                $jenis = JenisLayanan::find($this->filterJenis);
                $rows->push(['Jenis Layanan', $jenis?->nama_layanan ?? '-', '', '', '', '']);
            }
            $rows->push(['', '', '', '', '', '']);
        }

        // ── Ambil data ──
        $data = LayananPaspor::with(['jenisLayanan', 'lokasiLayanan', 'kanim', 'operator'])
            ->where('kanwil_id', $this->kanwilId)
            ->when($this->filterKanim,  fn($q) => $q->where('doklan_layanan_paspor.kanim_id', $this->filterKanim))
            ->when($this->filterLokasi, fn($q) => $q->where('lokasi_layanan_id', $this->filterLokasi))
            ->when($this->filterDari,   fn($q) => $q->where('tanggal', '>=', $this->filterDari))
            ->when($this->filterSampai, fn($q) => $q->where('tanggal', '<=', $this->filterSampai))
            ->when($this->filterJenis,  fn($q) => $q->where('jenis_layanan_id', $this->filterJenis))
            ->orderBy('tanggal', 'desc')
            ->get();

        $total = $data->sum('jumlah');

        // ── Ringkasan Per Kanim ──
        $this->sectionRows['kanim_header'] = $rows->count() + 1;
        $rows->push(['RINGKASAN PER KANTOR IMIGRASI', '', '']);
        $this->sectionRows['kanim_thead'] = $rows->count() + 1;
        $rows->push(['Kantor Imigrasi', 'Jumlah', '%']);
        foreach ($data->groupBy('kanim_id') as $items) {
            $t = $items->sum('jumlah');
            $rows->push([
                $items->first()->kanim?->nama_kanim ?? '-',
                $t,
                $total > 0 ? round($t / $total * 100, 1) . '%' : '0%',
            ]);
        }
        $this->sectionRows['kanim_total'] = $rows->count() + 1;
        $rows->push(['Total', $total, '100%']);
        $rows->push(['', '', '']);

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
        $rows->push(['DATA DETAIL', '', '', '', '', '', '', '']);
        $this->sectionRows['detail_thead'] = $rows->count() + 1;
        $rows->push(['No', 'Tanggal', 'Kanim', 'Jenis Layanan', 'Lokasi Layanan', 'Jumlah', 'Operator', 'Status']);
        $this->sectionRows['detail_data_start'] = $rows->count() + 1;

        $no = 1;
        foreach ($data as $item) {
            $rows->push([
                $no++,
                Carbon::parse($item->tanggal)->format('d/m/Y'),
                $item->kanim?->nama_kanim         ?? '-',
                $item->jenisLayanan?->nama_layanan ?? '-',
                $item->lokasiLayanan?->nama_lokasi ?? '-',
                $item->jumlah,
                $item->operator?->nama_lengkap     ?? '(Kanwil)',
                ucfirst($item->status),
            ]);
        }

        $this->sectionRows['detail_total'] = $rows->count() + 1;
        $rows->push(['', '', '', '', 'TOTAL', $total, '', '']);

        return $rows;
    }

    public function styles(Worksheet $sheet): array { return []; }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $s = $this->sectionRows;

                $sheet->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1E3A8A']]]);
                $sheet->getStyle('A2:A3')->applyFromArray(['font' => ['size' => 10, 'color' => ['rgb' => '64748B']]]);

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

                // Filter
                if (isset($s['filter_header'])) {
                    $sheet->getStyle('A' . $s['filter_header'] . ':B' . $s['filter_header'])->applyFromArray($navyStyle);
                }

                // Kanim
                foreach (['kanim', 'lokasi', 'jenis'] as $sec) {
                    $sheet->getStyle('A' . $s[$sec.'_header'] . ':C' . $s[$sec.'_header'])->applyFromArray($navyStyle);
                    $sheet->getStyle('A' . $s[$sec.'_thead'] . ':C' . $s[$sec.'_thead'])->applyFromArray($theadStyle);
                    $dataStart = $s[$sec.'_thead'] + 1;
                    $dataEnd   = $s[$sec.'_total'] - 1;
                    if ($dataEnd >= $dataStart) {
                        $sheet->getStyle("A{$dataStart}:C{$dataEnd}")->applyFromArray($dataStyle);
                        for ($r = $dataStart; $r <= $dataEnd; $r++) {
                            if ($r % 2 === 0) {
                                $sheet->getStyle("A{$r}:C{$r}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
                            }
                        }
                    }
                    $sheet->getStyle('A' . $s[$sec.'_total'] . ':C' . $s[$sec.'_total'])->applyFromArray($totalStyle);
                    $sheet->getStyle('B' . $s[$sec.'_thead'] . ':C' . $s[$sec.'_total'])->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                }

                // Detail
                $sheet->getStyle('A' . $s['detail_header'] . ':H' . $s['detail_header'])->applyFromArray($navyStyle);
                $sheet->getStyle('A' . $s['detail_thead'] . ':H' . $s['detail_thead'])->applyFromArray($theadStyle);
                $detailDataEnd = $s['detail_total'] - 1;
                if ($detailDataEnd >= $s['detail_data_start']) {
                    $sheet->getStyle('A' . $s['detail_data_start'] . ':H' . $detailDataEnd)->applyFromArray($dataStyle);
                    for ($r = $s['detail_data_start']; $r <= $detailDataEnd; $r++) {
                        if ($r % 2 === 0) {
                            $sheet->getStyle("A{$r}:H{$r}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
                        }
                    }
                    $sheet->getStyle('A' . $s['detail_data_start'] . ':A' . $detailDataEnd)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F' . $s['detail_data_start'] . ':F' . $detailDataEnd)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                $sheet->getStyle('A' . $s['detail_total'] . ':H' . $s['detail_total'])->applyFromArray($totalStyle);
                $sheet->getStyle('F' . $s['detail_total'])->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Column widths
                $sheet->getColumnDimension('A')->setWidth(6);
                $sheet->getColumnDimension('B')->setWidth(14);
                $sheet->getColumnDimension('C')->setWidth(28);
                $sheet->getColumnDimension('D')->setWidth(26);
                $sheet->getColumnDimension('E')->setWidth(26);
                $sheet->getColumnDimension('F')->setWidth(10);
                $sheet->getColumnDimension('G')->setWidth(24);
                $sheet->getColumnDimension('H')->setWidth(14);
            },
        ];
    }
}