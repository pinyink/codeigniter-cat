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
                $btn = '';
                if(enforce(4, 3)) {
                    $btn .= '<a href="javascript:;" class="ml-2" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit_soal('.$row->id.')"><i class="fa fa-edit"></i></a>';
                }

                if(enforce(4, 4)) {
                    $btn .= '<a href="javascript:;" class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Delete Data" onclick="delete_soal('.$row->id.')"><i class="fa fa-trash"></i></a>';
                }
                return $btn;
            }, 'first')
            ->addNumbering('no')
            ->setSearchableColumns(['nama'])
            ->toJson(true);
    }

    public function saveData()
    {
        $data['ref_formasi'] = $this->request->getPost('formasi');
        $data['ref_jenis_soal'] = $this->request->getPost('jenis_soal');
        $data['jumlah'] = $this->request->getPost('jumlah');

        $id = $this->request->getPost('id');
        $method = $this->request->getPost('method');
        $refFormasiSoalModel = new RefFormasiSoalModel();
        if ($method == 'save') {
            $refFormasiSoalModel->insert($data);
        } else {
            $refFormasiSoalModel->update($id, $data);
        }
        return $this->response->setJSON(['errorCode' => '1']);
    }

    public function detailData($id)
    {
        $query = $this->refFormasiSoalModel->select('
        ref_formasi_soal.id, 
        ref_formasi_soal.ref_formasi, 
        ref_formasi.nama formasi_nama,
        ref_formasi_soal.ref_jenis_soal, 
        ref_jenis_soal.nama jenis_soal_nama,
        ref_formasi_soal.jumlah')
        ->join('ref_formasi', 'ref_formasi.id = ref_formasi_soal.ref_formasi', 'left')
        ->join('ref_jenis_soal', 'ref_jenis_soal.id = ref_formasi_soal.ref_jenis_soal', 'left')
        ->where('ref_formasi_soal.id', $id)->first();
        return $this->response->setJSON($query);
    }

    public function deleteData($id){
        $query = $this->refFormasiSoalModel->find($id);
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'ref_formasi' => $query
        ];
        $delete = $this->refFormasiSoalModel->delete($id);
        if($delete) {
            $log['errorCode'] = 1;
        } else {
            $log['errorCode'] = 2;
        }
        return $this->response->setJSON($log);
    }
}
