<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Tema;
use Hermawan\DataTables\DataTable;

use App\Models\RefJenisSoalModel;

class RefJenisSoalController extends BaseController
{
    private $tema;
    private $refJenisSoalModel;

    function __construct()
    {
        helper(['form']);
        $this->tema = new Tema();
        $this->refJenisSoalModel = new RefJenisSoalModel();
        
    }

    public function index()
    {
        $this->tema->setJudul('Ref Jenis Soal');
        $this->tema->loadTema('ref_jenis_soal/index');
    }

	public function ajaxList()
    {
        $this->refJenisSoalModel->select('id, nama')->where('deleted_at', null);

        return DataTable::of($this->refJenisSoalModel)
            ->add('action', function($row){
                $btn = '<a href="'.base_url('ref_jenis_soal/'.$row->id.'/detail').'" class="" data-toggle="tooltip" data-placement="top" title="Lihat Data"><i class="fa fa-search"></i></a>';
                if(enforce(1, 3)) {
                    $btn .= '<a href="'.base_url('ref_jenis_soal/'.$row->id.'/edit').'" class="ml-2" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fa fa-edit"></i></a>';
                }

                if(enforce(1, 4)) {
                    $btn .= '<a href="javascript:;" class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Delete Data" onclick="delete_data('.$row->id.')"><i class="fa fa-trash"></i></a>';
                }
                return $btn;
            }, 'first')
            ->setSearchableColumns(['nama'])
            ->toJson();
    }

	public function rules($id = null)
    {
        $rules = [
			'nama' => [
                'label' => 'Nama Jenis Soal',
                'rules' => 'required|is_unique[ref_jenis_soal.nama, id, '.$id.']|max_length[64]|alpha_numeric_space',
                'errors' => [
                    'required' => '{field} Harus di isi',
					'is_unique' => '{field} Sudah Ada, harap ketik yang lainnya',
					'max_length' => '{field} Maksimal 64 Huruf',
					'alpha_numeric_space' => '{field} Hanya berupa huruf, angka dan spasi'
                ]
            ],
        ];

        return $rules;
    }

	public function tambahData(){
        $data = [
            'button' => 'Simpan',
            'id' => '',
            'method' => 'save',
            'url' => 'ref_jenis_soal/save'
        ];
        $this->tema->setJudul('Tambah Ref Jenis Soal');
        $this->tema->loadTema('ref_jenis_soal/tambah', $data);
    }

	public function editData($id){
        $query = $this->refJenisSoalModel->detail(['a.id' => $id])->getRowArray();
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'button' => 'Simpan',
            'id' => $id,
            'method' => 'update',
            'url' => 'ref_jenis_soal/update',
            'ref_jenis_soal' => $query
        ];
        $this->tema->setJudul('Edit Ref Jenis Soal');
        $this->tema->loadTema('ref_jenis_soal/edit', $data);
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
                $id = $this->refJenisSoalModel->insert($validData);
                return redirect()->to('ref_jenis_soal/'.$id.'/detail')->with('message', '<div class="alert alert-success">Simpan Data Berhasil</div>');
            } else {
                $this->refJenisSoalModel->update($id, $validData);
                return redirect()->to('ref_jenis_soal/'.$id.'/edit')->with('message', '<div class="alert alert-success">Update Data Berhasil</div>');
            }
        } else {
            if($method == 'save') {
                return redirect()->to('ref_jenis_soal/tambah')->withInput();
            } else {
                return redirect()->to('ref_jenis_soal/'.$id.'/edit')->withInput();
            }
        }
        
    }

	public function detailData($id){
        $query = $this->refJenisSoalModel->detail(['a.id' => $id])->getRowArray();
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'ref_jenis_soal' => $query
        ];
        $this->tema->setJudul('Detail Ref Jenis Soal');
        $this->tema->loadTema('ref_jenis_soal/detail', $data);
    }

	public function deleteData($id){
        $query = $this->refJenisSoalModel->find($id);
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'ref_jenis_soal' => $query
        ];
        $delete = $this->refJenisSoalModel->delete($id);
        if($delete) {
            $log['errorCode'] = 1;
        } else {
            $log['errorCode'] = 2;
        }
        return $this->response->setJSON($log);
    }
}