<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Tema;
use Hermawan\DataTables\DataTable;

use App\Models\RefFormasiModel;

class RefFormasiController extends BaseController
{
    private $tema;
    private $refFormasiModel;

    function __construct()
    {
        helper(['form']);
        $this->tema = new Tema();
        $this->refFormasiModel = new RefFormasiModel();
        
    }

    public function index()
    {
        $this->tema->setJudul('Ref Formasi');
        $this->tema->loadTema('ref_formasi/index');
    }

	public function ajaxList()
    {
        $this->refFormasiModel->select('id, nama')->where('deleted_at', null);

        return DataTable::of($this->refFormasiModel)
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

	public function rules($id = null)
    {
        $rules = [
			'nama' => [
                'label' => 'Formasi',
                'rules' => 'required|is_unique[ref_formasi.nama, id, '.$id.']|min_length[1]|max_length[128]|alpha_numeric_space',
                'errors' => [
                    'required' => '{field} Harus di isi',
					'is_unique' => '{field} Sudah Ada, harap ketik yang lainnya',
					'min_length' => '{field} Harus Lebih Dari 1 Huruf',
					'max_length' => '{field} Maksimal 128 Huruf',
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
            'url' => 'ref_formasi/save'
        ];
        $this->tema->setJudul('Tambah Ref Formasi');
        $this->tema->loadTema('ref_formasi/tambah', $data);
    }

	public function editData($id){
        $query = $this->refFormasiModel->detail(['a.id' => $id])->getRowArray();
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'button' => 'Simpan',
            'id' => $id,
            'method' => 'update',
            'url' => 'ref_formasi/update',
            'ref_formasi' => $query
        ];
        $this->tema->setJudul('Edit Ref Formasi');
        $this->tema->loadTema('ref_formasi/edit', $data);
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
                $id = $this->refFormasiModel->insert($validData);
                return redirect()->to('ref_formasi/'.$id.'/detail')->with('message', '<div class="alert alert-success">Simpan Data Berhasil</div>');
            } else {
                $this->refFormasiModel->update($id, $validData);
                return redirect()->to('ref_formasi/'.$id.'/edit')->with('message', '<div class="alert alert-success">Update Data Berhasil</div>');
            }
        } else {
            if($method == 'save') {
                return redirect()->to('ref_formasi/tambah')->withInput();
            } else {
                return redirect()->to('ref_formasi/'.$id.'/edit')->withInput();
            }
        }
        
    }

	public function detailData($id){
        $query = $this->refFormasiModel->detail(['a.id' => $id])->getRowArray();
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'ref_formasi' => $query
        ];
        $this->tema->setJudul('Detail Ref Formasi');
        $this->tema->loadTema('ref_formasi/detail', $data);
    }

	public function deleteData($id){
        $query = $this->refFormasiModel->find($id);
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'ref_formasi' => $query
        ];
        $delete = $this->refFormasiModel->delete($id);
        if($delete) {
            $log['errorCode'] = 1;
        } else {
            $log['errorCode'] = 2;
        }
        return $this->response->setJSON($log);
    }
}