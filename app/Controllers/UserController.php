<?php
namespace App\Controllers;

use App\Core\Controller;

/**
 * User Controller - Manages user profile and settings
 */
class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Show user profile
     */
    public function profile()
    {
        $data = [
            'title' => 'Meu Perfil',
            'user' => $this->auth->getUser()
        ];
        
        $this->view->render('users/profile', $data);
    }
    
    /**
     * Show user settings
     */
    public function settings()
    {
        $data = [
            'title' => 'Configurações',
            'user' => $this->auth->getUser()
        ];
        
        $this->view->render('users/settings', $data);
    }
}