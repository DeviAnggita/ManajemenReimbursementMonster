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

class ReimbursementKaryawanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    private $tahun_terpilih;

    public function __construct($tahun_terpilih)
    {
        $this->tahun_terpilih = $tahun_terpilih;
    }

    
    public function collection()
    {
        $loggedInUserId = Auth::id();
        $currentYear = date('Y');

        $data = DB::table('tb_reimbursement')
            ->select(
                DB::raw('(@num := @num + 1) AS no'),
                'users.nomor_identitas_karyawan',
                'users.nama_karyawan',
                'tb_jenis_reimbursement.nama_jenis_reimbursement',
                'tb_status_pengajuan.nama_status_pengajuan',
                DB::raw("DATE_FORMAT(tb_reimbursement.tanggal_bayar, '%d-%m-%Y') as tanggal_bayar"),
                DB::raw("DATE_FORMAT(tb_reimbursement.tanggal_reimbursement, '%d-%m-%Y') as tanggal_reimbursement"),
                'tb_reimbursement.keterangan',
                'tb_reimbursement.total'
            )
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user') // Menambahkan join dengan tabel 'users'
            ->leftJoin('tb_jenis_reimbursement', 'tb_reimbursement.id_jenis_reimbursement', '=', 'tb_jenis_reimbursement.id_jenis_reimbursement')
            ->leftJoin('tb_status_pengajuan', 'tb_reimbursement.id_status_pengajuan', '=', 'tb_status_pengajuan.id_status_pengajuan')
            ->leftJoin('tb_status_pengajuan as tb_status_pengajuan_mk', 'tb_reimbursement.id_status_pengajuan_mk', '=', 'tb_status_pengajuan_mk.id_status_pengajuan')
            ->leftJoin('tb_status_pengajuan as tb_status_pengajuan_sk', 'tb_reimbursement.id_status_pengajuan_sk', '=', 'tb_status_pengajuan_sk.id_status_pengajuan')
            ->leftJoin('tb_status_pengajuan as tb_status_pengajuan_ky', 'tb_reimbursement.id_status_pengajuan_ky', '=', 'tb_status_pengajuan_ky.id_status_pengajuan')
            ->crossJoin(DB::raw('(SELECT @num := 0) AS dummy'))
            ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
            ->whereYear('tb_reimbursement.tanggal_reimbursement', $this->tahun_terpilih) // Filter data berdasarkan tahun terpilih
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->orderBy('no') // Sort by 'no' column
            ->orderBy('users.nama_karyawan') // Sort by 'nama_karyawan' column
            ->get();

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
            'Keterangan',
            'Total'
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