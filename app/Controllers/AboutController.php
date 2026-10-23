<?php
namespace App\Controllers;

use App\Core\Controller;

class AboutController extends Controller
{
    public function index(): string { return $this->render('about/index'); }
}
