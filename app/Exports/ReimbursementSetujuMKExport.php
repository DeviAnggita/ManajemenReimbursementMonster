<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReimbursementSetujuMKExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    private $bulan_terpilih;
    private $tahun_terpilih;
    private $searchValue;
    
    public function __construct($bulan_terpilih, $tahun_terpilih,$searchValue)
    {
        $this->bulan_terpilih = $bulan_terpilih;
        $this->tahun_terpilih = $tahun_terpilih;
        $this->searchValue = $searchValue;
    }

    public function collection()
    {

        $query= DB::table('tb_reimbursement')
            ->selectRaw('
                ROW_NUMBER() OVER (ORDER BY users.nama_karyawan) AS no,
                users.nomor_identitas_karyawan,
                users.nama_karyawan,
                tb_jenis_reimbursement.nama_jenis_reimbursement,
                COALESCE(tb_status_pengajuan_ky.nama_status_pengajuan, tb_status_pengajuan_mk.nama_status_pengajuan, tb_status_pengajuan.nama_status_pengajuan) AS nama_status_pengajuan,
                DATE_FORMAT(tb_reimbursement.tanggal_bayar, "%d-%m-%Y") as tanggal_bayar,
                DATE_FORMAT(tb_reimbursement.tanggal_reimbursement, "%d-%m-%Y") as tanggal_reimbursement,
                tb_reimbursement.total,
                tb_reimbursement.keterangan
                ')
                ->leftJoin('users', 'tb_reimbursement.id_user', '=', 'users.id_user') // Menambahkan join dengan tabel 'users'
                ->leftJoin('tb_jenis_reimbursement', 'tb_reimbursement.id_jenis_reimbursement', '=', 'tb_jenis_reimbursement.id_jenis_reimbursement')
                ->leftJoin('tb_status_pengajuan', 'tb_reimbursement.id_status_pengajuan', '=', 'tb_status_pengajuan.id_status_pengajuan')
                ->leftJoin('tb_status_pengajuan as tb_status_pengajuan_mk', 'tb_reimbursement.id_status_pengajuan_mk', '=', 'tb_status_pengajuan_mk.id_status_pengajuan')
                ->leftJoin('tb_status_pengajuan as tb_status_pengajuan_ky', 'tb_reimbursement.id_status_pengajuan_ky', '=', 'tb_status_pengajuan_ky.id_status_pengajuan')
                ->where('users.hapus', '=', 0) //tidak terhapus
                ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
                ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
                ->where('users.status_active', '=', 1) //aktif
                ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
                ->whereIn('tb_status_pengajuan_mk.id_status_pengajuan', [8])
                ->orderBy('no') // Sort by 'no' column
                ->orderBy('users.nama_karyawan'); // Sort by 'nama_karyawan' column

            
            if ($this->bulan_terpilih !== 'all') {
                $query->whereMonth('tb_reimbursement.tanggal_reimbursement', $this->bulan_terpilih);
            }
        
            if ($this->tahun_terpilih !== 'all') {
                $query->whereYear('tb_reimbursement.tanggal_reimbursement', $this->tahun_terpilih);
            }
        
            if ($this->searchValue) {
                $query->where(function ($query) {
                    $query->where('users.nomor_identitas_karyawan', 'like', '%' . $this->searchValue . '%')
            
                        ->orWhere(function ($query) {
                            $query->where('users.nama_karyawan', 'like', '%' . $this->searchValue . '%')
                            ->orWhere('tb_status_pengajuan.nama_status_pengajuan', 'like', '%' . $this->searchValue . '%')
                            ->orWhere('tb_status_pengajuan_mk.nama_status_pengajuan', 'like', '%' . $this->searchValue . '%')
                            ->orWhere('tb_status_pengajuan_ky.nama_status_pengajuan', 'like', '%' . $this->searchValue . '%')
                            ->orWhere('tb_jenis_reimbursement.nama_jenis_reimbursement', 'like', '%' . $this->searchValue . '%');
                        })
                        
                        ->orWhere('tb_reimbursement.total', '=', str_replace('.', '', $this->searchValue))
                        
                        ->orWhere(function ($query) {
                            $date = Str::of($this->searchValue)->explode('-')->reverse()->join('-');
                            if (Carbon::hasFormat($date, 'd F Y')) {
                                $formattedDate = Carbon::parse($date)->locale('id')->isoFormat('YYYY-MM-DD');
                                $query->where('tb_reimbursement.tanggal_reimbursement', '=', $formattedDate);
                            }
                        });        
                });
            }

            $query->groupBy(
                'tb_reimbursement.id_reimbursement',
                'users.nomor_identitas_karyawan',
                'users.nama_karyawan',
                'tb_jenis_reimbursement.nama_jenis_reimbursement',
                'tb_status_pengajuan.nama_status_pengajuan',
                'tb_status_pengajuan_mk.nama_status_pengajuan',
                'tb_status_pengajuan_ky.nama_status_pengajuan',
                'tb_reimbursement.tanggal_bayar',
                'tb_reimbursement.tanggal_reimbursement',
                'tb_reimbursement.keterangan',
                'tb_reimbursement.total'
            );
             
            $data = $query->get();
        
            return $data;
            
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Identitas Karyawan',
            'Nama Karyawan',
            'Nama Jenis Reimbursement',
            'Nama Status Pengajuan',
            'Tanggal Bayar',
            'Tanggal Reimbursement',
            'Total',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFF00',
                ],
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('A:I')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    }
}