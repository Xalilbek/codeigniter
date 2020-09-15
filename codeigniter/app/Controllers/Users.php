<?php namespace App\Controllers;

use App\Models\UserModel;


class Users extends BaseController
{
	public function index()
	{
		$data = [];
		helper(['form']);
//		var_dump($this->request->getMethod());exit();

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];

			$errors = [
				'password' => [
					'validateUser' => 'Email or Password don\'t match'
				]
			];

			if (! $this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			}else{
				$model = new UserModel();

				$user = $model->where('email', $this->request->getVar('email'))->where('is_deleted', 0)
											->first();
				$this->setUserSession($user);
				//$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('dashboard');

			}
		}

		echo view('templates/header', $data);
		echo view('login');
		echo view('templates/footer');
	}

	private function setUserSession($user){
		$data = [
			'id' => $user['id'],
			'firstname' => $user['firstname'],
			'lastname' => $user['lastname'],
			'email' => $user['email'],
			'is_admin' => $user['is_admin'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
	}

	public function register(){
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'firstname' => 'required|min_length[3]|max_length[20]',
				'lastname' => 'required|min_length[3]|max_length[20]',
				'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{
				$model = new UserModel();


				$newData = [
					'firstname' => $this->request->getVar('firstname'),
					'lastname' => $this->request->getVar('lastname'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
					'is_deleted' => 0,
                    'is_admin'=> count($model->findAll())>0 ? 0 : 1,
				];
				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('/');

			}
		}


		echo view('templates/header', $data);
		echo view('register');
		echo view('templates/footer');
	}

	public function profile(){
		
		$data = [];
		helper(['form']);
		$model = new UserModel();

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'firstname' => 'required|min_length[3]|max_length[20]',
				'lastname' => 'required|min_length[3]|max_length[20]',
				];

			if($this->request->getPost('password') != ''){
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}


			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{

				$newData = [
					'id' => session()->get('id'),
					'firstname' => $this->request->getPost('firstname'),
					'lastname' => $this->request->getPost('lastname'),
					];
					if($this->request->getPost('password') != ''){
						$newData['password'] = $this->request->getPost('password');
					}
				$model->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->to('/profile');

			}
		}

		$data['user'] = $model->where('id', session()->get('id'))->first();
		echo view('templates/header', $data);
		echo view('profile');
		echo view('templates/footer');
	}
	public function addedituser(){

		$data = [];
		helper(['form']);
		$model = new UserModel();
        if ($this->request->getMethod() == 'post') {
			//let's do the validation here
            if($this->request->getPost('id')!=''){
                $rules = [
                    'firstname' => 'required|min_length[3]|max_length[20]',
                    'lastname' => 'required|min_length[3]|max_length[20]',
                    ];

                if($this->request->getPost('password') != ''){
                    $rules['password'] = 'required|min_length[8]|max_length[255]';
                    $rules['password_confirm'] = 'matches[password]';
                }


                if (! $this->validate($rules)) {
                    $data['validation'] = $this->validator;
                }else {
                    $newData = [
                        'id' => $this->request->getPost('id'),
                        'firstname' => $this->request->getPost('firstname'),
                        'lastname' => $this->request->getPost('lastname'),
                    ];
                    if ($this->request->getPost('password') != '') {
                        $newData['password'] = $this->request->getPost('password');
                    }
                    $model->save($newData);


                    return redirect()->to('/dashboard');
                }

			}else {
                $rules = [
                    'firstname' => 'required|min_length[3]|max_length[20]',
                    'lastname' => 'required|min_length[3]|max_length[20]',
                    'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                    'password' => 'required|min_length[8]|max_length[255]',
                    'password_confirm' => 'matches[password]',
                ];

                if (!$this->validate($rules)) {
                    $data['validation'] = $this->validator;
                } else {
                    $model = new UserModel();


                    $newData = [
                        'firstname' => $this->request->getVar('firstname'),
                        'lastname' => $this->request->getVar('lastname'),
                        'email' => $this->request->getVar('email'),
                        'password' => $this->request->getVar('password'),
                        'is_deleted' => 0,
                        'is_admin' => count($model->findAll()) > 0 ? 0 : 1,
                    ];
                    $model->save($newData);
                    return redirect()->to('/dashboard');
                }
            }
		}
        if($this->request->getGet('id')!=''){
            $data['user'] = $model->where('id', $this->request->getGet('id'))->first();

        }
		echo view('templates/header', $data);
		echo view('addedituser');
		echo view('templates/footer');
	}

	public function delete(){
        $data = [];
        helper(['form']);
        $model = new UserModel();

        if ($this->request->getMethod() == 'post') {
            //let's do the validation here
            if ($this->request->getPost('id') != '') {

                $newData = [
                    'is_deleted' => 1,
                ];
                $model->save($newData);


                return redirect()->to('/dashboard');

            }
        }
    }

	public function logout(){
		session()->destroy();
		return redirect()->to('/');
	}

	//--------------------------------------------------------------------

}
