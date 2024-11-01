<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RefFormasiSoalModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class RefFormasiSoalController extends BaseController
{

    private $tema;
    private $refFormasiSoalModel;

    function __construct()
    {
        $this->refFormasiSoalModel = new RefFormasiSoalModel();
        
    }

    public function ajaxList()
    {
        $this->refFormasiSoalModel->select('
            ref_formasi_soal.id, 
            ref_formasi_soal.ref_formasi, 
            ref_formasi.nama formasi_nama,
            ref_formasi_soal.ref_jenis_soal, 
            ref_jenis_soal.nama jenis_soal_nama,
            ref_formasi_soal.jumlah')
            ->join('ref_formasi', 'ref_formasi.id = ref_formasi_soal.ref_formasi', 'left')
            ->join('ref_jenis_soal', 'ref_jenis_soal.id = ref_formasi_soal.ref_jenis_soal', 'left')
            ->where('ref_formasi_soal.deleted_at', null);

        return DataTable::of($this->refFormasiSoalModel)
            ->add('action', function($row){
                $btn = '<a href="'.base_url('ref_formasi/'.$row->id.'/detail').'" class="" data-toggle="tooltip" data-placement="top" title="Lihat Data"><i class="fa fa-search"></i></a>';
                if(enforce(4, 3)) {
                    $btn .= '<a href="'.base_url('ref_formasi/'.$row->id.'/edit').'" class="ml-2" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fa fa-edit"></i></a>';
                }

                if(enforce(4, 4)) {
                    $btn .= '<a href="javascript:;" class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Delete Data" onclick="delete_data('.$row->id.')"><i class="fa fa-trash"></i></a>';
                }
                return $btn;
            }, 'first')
            ->addNumbering('no')
            ->setSearchableColumns(['nama'])
            ->toJson(true);
    }
}
