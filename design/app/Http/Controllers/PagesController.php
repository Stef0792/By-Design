<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
 
class PagesController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    // public $layout = 'admin';

    public function dashboard()
    {
        // \Session::flush();
        $test = $this->getConfigFile();
        // print_r($test); exit;
        return view('dashboard');
    }

    public function getIndex(){
        return parent::getIndex();
    }

    public function login(){
        return view('login');
    }

    public function killSession(){
        \Session::flush();
        return redirect('/login');
    }
}
