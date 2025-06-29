<?php

namespace App\Controllers\Admin_controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class Admin_controller extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        helper(['form', 'url', 'admin']);
    }

    //* funcion para verificar si un usuario es administrador
    private function verificarAdmin()
    {
        if (!session()->get('is_admin')) {
            session()->setFlashdata('error', 'No tienes permisos para acceder a esta sección.');
            return redirect()->to('/');
        }
    }

    public function admin()
    {
        // verificamos si el usuario es administrador
        $this->verificarAdmin();

        // estadisticas para el dashboard
        $data['titulo'] = 'Sección de Administrador';
        $data['total_usuarios'] = $this->usuarioModel->countAll();
        $data['usuarios_activos'] = $this->usuarioModel->where('is_active', 1)->countAllResults();
        $data['usuarios_inactivos'] = $this->usuarioModel->where('is_active', 0)->countAllResults();
        $data['total_admins'] = $this->usuarioModel->where('is_admin', 1)->countAllResults();

        echo view('front/navbar', $data);
        echo view('Back/admin/admin', $data);
        echo view('front/footer');
    }

    //* funcion que nos trae toda la informacion para el dashboard de usuarios
    public function usuarios()
    {
        $this->verificarAdmin();

        // parametros de filtrado y paginacion
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';
        $role = $this->request->getGet('role') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;

        // contruimos la consulta con filtros
        $builder = $this->usuarioModel;

        if (!empty($search)) {
            $builder = $builder->groupStart()
                ->like('nickname', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        // rol de usuario activo
        if ($status !== '') {
            $builder = $builder->where('is_active', $status);
        }

        // rol de usuario administrador
        if ($role !== '') {
            $builder = $builder->where('is_admin', $role);
        }

        // obtenemos los datos paginados
        $data['titulo'] = 'Gestión de Usuarios - Admin';
        $data['usuarios'] = $builder->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);
        $data['pager'] = $this->usuarioModel->pager;

        // creamos las avariables y obtenemos las estadisticas para el dashboard de usuarios
        $data['total_usuarios'] = $this->usuarioModel->countAll();
        $data['usuarios_activos'] = $this->usuarioModel->where('is_active', 1)->countAllResults();
        $data['usuarios_inactivos'] = $this->usuarioModel->where('is_active', 0)->countAllResults();
        $data['total_admins'] = $this->usuarioModel->where('is_admin', 1)->countAllResults();

        // filtros para la busqueda de usuarios
        $data['current_search'] = $search;
        $data['current_status'] = $status;
        $data['current_role'] = $role;

        echo view('front/navbar', $data);
        echo view('Back/admin/users-admin', $data);
        echo view('front/footer');
    }

    //* funcion que nos permite acceder a la seccion donde podremos visualizar mas en detalle la informacion de un usuario (proximamente)
    public function verUsuario($id)
    {
        // verificamos que el usuario sea administrador
        $this->verificarAdmin();

        // buscamos el usuario por su user_id
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            session()->setFlashdata('error', 'Usuario no encontrado.');
            return redirect()->to('admin/usuarios');
        }

        $data['titulo'] = 'Ver Usuario - ' . $usuario['nickname'];
        $data['usuario'] = $usuario;

        echo view('front/navbar', $data);
        echo view('Back/admin/usuarios/ver', $data);
        echo view('front/footer');
    }

    //* funcion que nos permite acceder a la seccion de edicion de usuarios (proximamente)
    public function editarUsuario($id)
    {
        // verificamos si es usuario administrador
        $this->verificarAdmin();

        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            session()->setFlashdata('error', 'Usuario no encontrado.');
            return redirect()->to('admin/usuarios');
        }

        $data['titulo'] = 'Editar Usuario - ' . $usuario['nickname'];
        $data['usuario'] = $usuario;

        echo view('front/navbar', $data);
        echo view('Back/admin/usuarios/editar', $data);
        echo view('front/footer');
    }

    //* funcion que nos permite actualizar la informacion de un usuario () */ 
    public function actualizarUsuario($id)
    {
        // verificamos que el usuario sea administrador
        $this->verificarAdmin();

        // buscamos el usuario por su user_id
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            session()->setFlashdata('error', 'Usuario no encontrado.');
            return redirect()->to('admin/usuarios');
        }

        // establecemos las reglas al momento de modificar los datos de un usuario
        $rules = [
            'nickname' => "required|min_length[3]|is_unique[usuarios.nickname,user_id,{$id}]",
            'email' => "required|valid_email|is_unique[usuarios.email,user_id,{$id}]",
            'is_active' => 'required|in_list[0,1]',
            'is_admin' => 'required|in_list[0,1]'
        ];

        // establecemos reglas para la password
        if (!empty($this->request->getPost('password'))) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }

        // en caso de una validacion erronea, recarga la pagina con los errores
        if (!$this->validate($rules)) {
            $data['titulo'] = 'Editar Usuario - ' . $usuario['nickname'];
            $data['usuario'] = $usuario;
            $data['validation'] = $this->validator;

            echo view('front/navbar', $data);
            echo view('Back/admin/usuarios/editar', $data);
            echo view('front/footer');
            return;
        }

        // preparamos los datos del usuario para actualizarlos mas adelante
        $updateData = [
            'nickname' => $this->request->getPost('nickname'),
            'email' => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active'),
            'is_admin' => $this->request->getPost('is_admin')
        ];

        // guardamos y hasheamos la password
        if (!empty($this->request->getPost('password'))) {
            $updateData['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // actualizamos los datos del usuario
        $this->usuarioModel->update($id, $updateData);

        session()->setFlashdata('success', 'Usuario actualizado exitosamente.');
        return redirect()->to('admin/usuarios');
    }

    //* funcion que nos permite eliminar la cuenta permanentemente de un usuario (ajax)
    public function eliminarUsuario($id)
    {
        $this->verificarAdmin();

        // hacemos esto para que un usuario no pueda eliminarse a si mismo
        if ($id == session()->get('user_id')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No puedes eliminar tu propia cuenta.'
            ]);
        }

        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ]);
        }

        if ($this->usuarioModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al eliminar el usuario.'
            ]);
        }
    }

    //* funcion para poder cambiar el estado de activo <-> inactivo de un usuario (ajax)
    public function cambiarEstado($id)
    {
        $this->verificarAdmin();

        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ]);
        }

        // cambiamos el estado del usuario (activo/inactivo)
        $nuevoEstado = $usuario['is_active'] ? 0 : 1;

        // una vez actualizado el estado de un usuario, se crea el json correspondiente con la informacion
        if ($this->usuarioModel->update($id, ['is_active' => $nuevoEstado])) {
            $mensaje = $nuevoEstado ? 'Usuario activado exitosamente.' : 'Usuario desactivado exitosamente.';
            return $this->response->setJSON([
                'success' => true,
                'message' => $mensaje,
                'nuevo_estado' => $nuevoEstado
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al cambiar el estado del usuario.'
            ]);
        }
    }

    //* funcion que nos permite acceder a la seccion para crear un usuario (proximamente)
    public function crearUsuario()
    {
        $this->verificarAdmin();

        $data['titulo'] = 'Crear Nuevo Usuario';

        echo view('front/navbar', $data);
        echo view('Back/admin/usuarios/crear', $data);
        echo view('front/footer');
    }

    //* funcion que permite a un administrador crear un usuario
    public function guardarUsuario()
    {
        $this->verificarAdmin();

        $rules = [
            'nickname' => 'required|min_length[3]|is_unique[usuarios.nickname]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'is_active' => 'required|in_list[0,1]',
            'is_admin' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            $data['titulo'] = 'Crear Nuevo Usuario';
            $data['validation'] = $this->validator;
            echo view('front/navbar', $data);
            echo view('Back/admin/usuarios/crear', $data);
            echo view('front/footer');
            return;
        }

        $userData = [
            'nickname' => $this->request->getPost('nickname'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => $this->request->getPost('is_active'),
            'is_admin' => $this->request->getPost('is_admin')
        ];

        if ($this->usuarioModel->save($userData)) {
            session()->setFlashdata('success', 'Usuario creado exitosamente.');
            return redirect()->to('admin/usuarios');
        } else {
            session()->setFlashdata('error', 'Error al crear el usuario.');
            return redirect()->back()->withInput();
        }
    }
}
