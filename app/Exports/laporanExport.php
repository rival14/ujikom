<?php

namespace App\Exports;

use DB;
use App\Pengaduan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeSheet;

class laporanExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Pengaduan::query()->where('status', 'selesai')->join('masyarakat', 'pengaduan.nik', '=', 'masyarakat.nik')->select('masyarakat.nama', 'tgl_pengaduan', 'judul', 'status');
    }

    public function headings(): array
    {
        return [
            'Nama Pelapor',
            'Tanggal Pengaduan',
            'Judul Pengaduan',
            'Status Laporan',
        ];
    }

    public static function beforeSheet(BeforeSheet $event){
        $event->sheet->appendRows(array(
            array('test1', 'test2'),
        ), $event);
    }
}
