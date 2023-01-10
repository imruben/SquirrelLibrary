<?php

namespace App\Controllers;

use App\Controller;
use App\Container;
use App\Request;
use App\Session;
use App\Model;
use App\Model\Llibre;
use App\Model\Prestec;
use App\Model\Usuari;

final class DashboardController extends Controller
{
    protected Usuari $user;

    function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
        // $user = new Usuari(Session::get('user'));
        // $this->user = $user;
    }

    public function index()
    {
        $user = Session::get('user');
        // print_r($user);

        if ($user) {
            return view('dashboard', ['username' => 'pablito', 'user' => $user]);
        } else {
            $this->redirect('/home');
        }

        // primer obtenir dades
        $llibres = new Llibre();
        $cataleg = $llibres->find(['disponible' => true]);
        $cataleg = $this->qb->select(['*'])->from('llibres')->exec()->fetch();
        // return view('dashboard', ['cataleg' => $cataleg, 'user' => $user]);
    }

    function reserva()
    {
        $id = $this->request->getParams();
        $llibre = (new Llibre())->find(['id' => $id])[0];

        return view('reserva', [
            'llibre' => $llibre,
            'user' => $this->user
        ]);
    }

    function prestec()
    {
        //crear prèstec
        $id = $this->request->getParams();
        $llibre = (new Llibre())->find(['id' => $id])[0];

        $prestec = new Prestec($this->user, $llibre);
    }

    function prestecs()
    {
        echo "prestecs";
    }
}