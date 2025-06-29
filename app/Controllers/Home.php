<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data['titulo'] = "FilmStream | Películas y Series";
        return view('../Views/front/navbar', $data) .
            view('../Views/front/popular') .
            view('../Views/front/footer');
    }

    public function peliculas(): string
    {
        $data['titulo'] = "Peliculas";
        return view('../Views/front/navbar', $data) .
            view('../Views/front/peliculas') .
            view('../Views/front/footer');
    }

    public function series(): string
    {
        $data['titulo'] = "Series";
        return view('../Views/front/navbar', $data) .
            view('../Views/front/series') .
            view('../Views/front/footer');
    }

    public function login(): string
    {
        $data['titulo'] = "Iniciar Sesion";
        return view('../Views/front/navbar', $data) .
            view('../Views/Back/usuario/login') .
            view('../Views/front/footer');
    }

    public function register(): string
    {
        $data['titulo'] = "Registrarse";
        return view('../Views/front/navbar', $data) .
            view('../Views/Back/usuario/register') .
            view('../Views/front/footer');
    }

    public function quienes_somos(): string
    {
        $data['titulo'] = "Quienes Somos";
        return view('../Views/front/navbar', $data) .
            view('../Views/front/quienes_somos') .
            view('../Views/front/footer');
    }

    public function acerca_de(): string
    {
        $data['titulo'] = "Acerca De";
        return view('../Views/front/navbar', $data) .
            view('../Views/front/acercade') .
            view('../Views/front/footer');
    }
}
