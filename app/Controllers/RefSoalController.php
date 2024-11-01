<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Tema;
use App\Models\RefJenisSoalModel;
use Hermawan\DataTables\DataTable;

use App\Models\RefSoalModel;

class RefSoalController extends BaseController
{
    private $tema;
    private $refSoalModel;

    function __construct()
    {
        helper(['form', 'formCustom']);
        $this->tema = new Tema();
        $this->refSoalModel = new RefSoalModel();
        
    }

    public function index()
    {
        $this->tema->setJudul('Ref Soal');
        $this->tema->loadTema('ref_soal/index');
    }

	public function ajaxList()
    {
        $this->refSoalModel->select('id, ref_jenis_soal, soal')->where('deleted_at', null);

        return DataTable::of($this->refSoalModel)
            ->add('action', function($row){
                $btn = '<a href="'.base_url('ref_soal/'.$row->id.'/detail').'" class="" data-toggle="tooltip" data-placement="top" title="Lihat Data"><i class="fa fa-search"></i></a>';
                if(enforce(2, 3)) {
                    $btn .= '<a href="'.base_url('ref_soal/'.$row->id.'/edit').'" class="ml-2" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fa fa-edit"></i></a>';
                }

                if(enforce(2, 4)) {
                    $btn .= '<a href="javascript:;" class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Delete Data" onclick="delete_data('.$row->id.')"><i class="fa fa-trash"></i></a>';
                }
                return $btn;
            }, 'first')
            ->addNumbering('no')
            ->setSearchableColumns(['ref_jenis_soal', 'soal'])
            ->toJson(true);
    }

	public function rules($id = null)
    {
        $rules = [
			'ref_jenis_soal' => [
                'label' => 'Jenis Soal',
                'rules' => 'required|min_length[1]|max_length[99]|alpha_numeric_space',
                'errors' => [
                    'required' => '{field} Harus di isi',
					'min_length' => '{field} Harus Lebih Dari 1 Huruf',
					'max_length' => '{field} Maksimal 99 Huruf',
					'alpha_numeric_space' => '{field} Hanya berupa huruf, angka dan spasi'
                ]
            ],
			'soal' => [
                'label' => 'Soal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus di isi'
                ]
            ],
        ];

        return $rules;
    }

	public function tambahData()
    {
        $jenisSoalModel = new RefJenisSoalModel();
        $data = [
            'button' => 'Simpan',
            'id' => '',
            'method' => 'save',
            'url' => 'ref_soal/save',
            'ref_jenis_soal' => $jenisSoalModel->findAll()
        ];
        $this->tema->setJudul('Tambah Ref Soal');
        $this->tema->loadTema('ref_soal/tambah', $data);
    }

	public function editData($id){
        $query = $this->refSoalModel->detail(['a.id' => $id])->getRowArray();
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $jenisSoalModel = new RefJenisSoalModel();
        $data = [
            'button' => 'Simpan',
            'id' => $id,
            'method' => 'update',
            'url' => 'ref_soal/update',
            'ref_soal' => $query,
            'ref_jenis_soal' => $jenisSoalModel->findAll()
        ];
        $this->tema->setJudul('Edit Ref Soal');
        $this->tema->loadTema('ref_soal/edit', $data);
    }

	public function saveData($id = null)
    {
        $validation = service('validation');
        $request    = service('request');
        //get method form
        $id = $request->getPost('id');
        $method = $request->getPost('method');
        //set rules validation
        $rules = $this->rules($id);
        
        $validation->setRules($rules);

        if ($validation->withRequest($request)->run()) {
            $validData = $validation->getValidated();
            
            if($method == 'save') {
                $id = $this->refSoalModel->insert($validData);
                return redirect()->to('ref_soal/'.$id.'/detail')->with('message', '<div class="alert alert-success">Simpan Data Berhasil</div>');
            } else {
                $this->refSoalModel->update($id, $validData);
                return redirect()->to('ref_soal/'.$id.'/edit')->with('message', '<div class="alert alert-success">Update Data Berhasil</div>');
            }
        } else {
            if($method == 'save') {
                return redirect()->to('ref_soal/tambah')->withInput();
            } else {
                return redirect()->to('ref_soal/'.$id.'/edit')->withInput();
            }
        }
        
    }

	public function detailData($id){
        $query = $this->refSoalModel->detail(['a.id' => $id])->getRowArray();
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'ref_soal' => $query
        ];
        $this->tema->setJudul('Detail Ref Soal');
        $this->tema->loadTema('ref_soal/detail', $data);
    }

	public function deleteData($id){
        $query = $this->refSoalModel->find($id);
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'ref_soal' => $query
        ];
        $delete = $this->refSoalModel->delete($id);
        if($delete) {
            $log['errorCode'] = 1;
        } else {
            $log['errorCode'] = 2;
        }
        return $this->response->setJSON($log);
    }
}