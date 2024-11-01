<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Tema;
use Hermawan\DataTables\DataTable;

use App\Models\ImagesModel;
use App\Libraries\UploadLib;
class ImagesController extends BaseController
{
    private $tema;
    private $imagesModel;
private $uploadLib;
    function __construct()
    {
        helper(['form']);
        $this->tema = new Tema();
        $this->imagesModel = new ImagesModel();
        $this->uploadLib = new UploadLib();
    }

    public function index()
    {
        $this->tema->setJudul('Images');
        $this->tema->loadTema('images/index');
    }

	public function ajaxList()
    {
        $this->imagesModel->select('id, ')->where('deleted_at', null);

        return DataTable::of($this->imagesModel)
            ->add('action', function($row){
                $btn = '<a href="'.base_url('images/'.$row->id.'/detail').'" class="" data-toggle="tooltip" data-placement="top" title="Lihat Data"><i class="fa fa-search"></i></a>';
                if(enforce(3, 3)) {
                    $btn .= '<a href="'.base_url('images/'.$row->id.'/edit').'" class="ml-2" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fa fa-edit"></i></a>';
                }

                if(enforce(3, 4)) {
                    $btn .= '<a href="javascript:;" class="text-danger ml-2" data-toggle="tooltip" data-placement="top" title="Delete Data" onclick="delete_data('.$row->id.')"><i class="fa fa-trash"></i></a>';
                }
                return $btn;
            }, 'first')
            ->addNumbering('no')
            ->setSearchableColumns([''])
            ->toJson(true);
    }

	public function rules($id = null)
    {
        $rules = [
        ];

        return $rules;
    }

	public function tambahData(){
        $data = [
            'button' => 'Simpan',
            'id' => '',
            'method' => 'save',
            'url' => 'images/save'
        ];
        $this->tema->setJudul('Tambah Images');
        $this->tema->loadTema('images/tambah', $data);
    }

	public function editData($id){
        $query = $this->imagesModel->detail(['a.id' => $id])->getRowArray();
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'button' => 'Simpan',
            'id' => $id,
            'method' => 'update',
            'url' => 'images/update',
            'images' => $query
        ];
        $this->tema->setJudul('Edit Images');
        $this->tema->loadTema('images/edit', $data);
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
        if (!empty($_FILES['images']['name'])) {
            $rules['images'] = $this->uploadLib->rulesImage('images', 'Images');
        }
        $validation->setRules($rules);

        if ($validation->withRequest($request)->run()) {
            $validData = $validation->getValidated();
            $images = $request->getFile('images');
            if (!empty($_FILES['images']['name'])) {
                $path = 'uploads/images/image/';
                $this->uploadLib->setFile($images);
                $this->uploadLib->setPath($path);
                $validData['images'] = $this->uploadLib->upload();
            }
            if($method == 'save') {
                $id = $this->imagesModel->insert($validData);
                return redirect()->to('images/'.$id.'/detail')->with('message', '<div class="alert alert-success">Simpan Data Berhasil</div>');
            } else {
                $this->imagesModel->update($id, $validData);
                return redirect()->to('images/'.$id.'/edit')->with('message', '<div class="alert alert-success">Update Data Berhasil</div>');
            }
        } else {
            if($method == 'save') {
                return redirect()->to('images/tambah')->withInput();
            } else {
                return redirect()->to('images/'.$id.'/edit')->withInput();
            }
        }
        
    }

	public function detailData($id){
        $query = $this->imagesModel->detail(['a.id' => $id])->getRowArray();
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'images' => $query
        ];
        $this->tema->setJudul('Detail Images');
        $this->tema->loadTema('images/detail', $data);
    }

	public function deleteData($id){
        $query = $this->imagesModel->find($id);
        if(empty($query)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'images' => $query
        ];
        $delete = $this->imagesModel->delete($id);
        if($delete) {
            $log['errorCode'] = 1;
        } else {
            $log['errorCode'] = 2;
        }
        return $this->response->setJSON($log);
    }
}