<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddTaskController extends Controller
{
    /**
     * @Route("/add/task", name="add_task")
     */
    public function index()
    {
        return $this->render('add_task/index.html.twig', [
            'controller_name' => 'AddTaskController',
        ]);
    }
}
