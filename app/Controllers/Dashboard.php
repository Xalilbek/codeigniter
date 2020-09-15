<?php namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
	public function index()
	{
        $model = new UserModel();
        $data = [];
        $data['users'] = $model->where('is_deleted', 0)->findAll();


		echo view('templates/header', $data);
		echo view('dashboard');
		echo view('templates/footer');
	}

	//--------------------------------------------------------------------

}
