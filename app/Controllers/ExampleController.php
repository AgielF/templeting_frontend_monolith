<?php
namespace App\Controllers;
use App\Models\ExampleModel;
class ExampleController extends BaseController
{
    public function index()
    {
        return view('admin/example/index', [
            'title' => 'Example CRUD',
            'items' => (new ExampleModel())->orderBy('id', 'DESC')->findAll(),
        ]);
    }
    public function store()
    {
        $model = new ExampleModel();
        if ($model->save($this->request->getPost())) {
            return redirect()->to('/admin/example')->with('success', 'Data berhasil ditambahkan');
        }
        return redirect()->back()->with('errors', $model->errors());
    }
    public function update($id)
    {
        $model = new ExampleModel();
        $data = $this->request->getPost();
        $data['id'] = $id;
        if ($model->save($data)) {
            return redirect()->to('/admin/example')->with('success', 'Data berhasil diupdate');
        }
        return redirect()->back()->with('errors', $model->errors());
    }
    public function delete($id)
    {
        (new ExampleModel())->delete($id);
        return redirect()->to('/admin/example')->with('success', 'Data berhasil dihapus');
    }
}
