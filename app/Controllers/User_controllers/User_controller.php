<?php

namespace App\Controllers\User_controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class User_controller extends Controller
{

    protected $formModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->formModel = new UsuarioModel();
    }

    public function register()
    {
        $data['titulo'] = 'Registro de Usuario';
        echo view('front/navbar', $data);
        echo view('Back/usuario/register');
        echo view('front/footer');
    }

    public function registerValidation()
    {
        $input = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El email es obligatorio',
                    'valid_email' => 'Por favor ingrese un email válido',
                    'is_unique' => 'Este email ya está registrado'
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[3]|is_unique[usuarios.nickname]',
                'errors' => [
                    'required' => 'El nombre de usuario es obligatorio',
                    'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres',
                    'is_unique' => 'Este nombre de usuario ya está en uso'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]|regex_match[/(?=.*[A-Z])^.{6,}$/]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria',
                    'min_length' => 'La contraseña debe tener al menos 6 caracteres',
                    'regex_match' => 'La contraseña debe tener al menos una letra mayúscula'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Debe confirmar la contraseña',
                    'matches' => 'Las contraseñas no coinciden'
                ]
            ],
            'terms' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe aceptar los terminos y condiciones'
                ]
            ]
        ]);

        if (!$input) {
            $data['titulo'] = 'Registro de Usuario';
            $data['validation'] = $this->validator;
            echo view('front/navbar', $data);
            echo view('Back/usuario/register', $data);
            echo view('front/footer');
            return;
        } else {
            $this->formModel->save([
                'nickname' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'password_hash' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'is_active' => 1
            ]);
        }

        session()->setFlashdata('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
        return $this->response->redirect('/login');
    }

    public function login()
    {
        $data['titulo'] = 'Iniciar Sesión';
        echo view('front/navbar', $data);
        echo view('Back/usuario/login');
        echo view('front/footer');
    }

    public function loginValidation()
    {
        $input = $this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El nombre de usuario es obligatorio'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La contraseña es obligatoria'
                ]
            ]
        ]);

        $formModel = new UsuarioModel();

        if (!$input) {
            $data['titulo'] = 'Iniciar Sesión';
            $data['validation'] = $this->validator;
            echo view('front/navbar', $data);
            echo view('Back/usuario/login', $data);
            echo view('front/footer');
            return;
        }

        $usuario = $formModel->where('nickname', $this->request->getVar('username'))->first();

        if (!$usuario) {
            session()->setFlashdata('error', 'El usuario no existe.');
            return $this->response->redirect('/login');
        }

        if ($usuario['is_active'] != 1) {
            session()->setFlashdata('error', 'Tu cuenta está desactivada.');
            return $this->response->redirect('/login');
        }

        if (!password_verify($this->request->getVar('password'), $usuario['password_hash'])) {
            session()->setFlashdata('error', 'Usuario o contraseña incorrecta.');
            return $this->response->redirect('/login');
        }

        $sessionData = [
            'user_id' => $usuario['user_id'],
            'email' => $usuario['email'],
            'nickname' => $usuario['nickname'],
            'is_active' => $usuario['is_active'],
            'is_admin' => $usuario['is_admin']
        ];

        session()->set($sessionData);

        $formModel->update($usuario['user_id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);

        return $this->response->redirect('/');
    }

    public function logout()
    {
        session()->destroy();
        return $this->response->redirect('/');
    }
}
