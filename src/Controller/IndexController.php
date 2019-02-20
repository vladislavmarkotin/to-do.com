<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Exception\Core\Type\TextareaType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller
{
    //use Symfony\Component\Form\FormTypeInterface;
    /**
     * @Route("/index", name="index")
     */
    public function index(Request $request)
    {
        // creates a task and gives it some dummy data for this example

        $task = $this->getDoctrine()
            ->getRepository(Task::class);

        if (!$task) {
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        $tasks = $task->findAll();

        return $this->render('add_task/index.html.twig', ["tasks" => $tasks]);
    }

    /**
     * @Route("/add", methods={"POST"}, name="add")
     */
    public function add(Request $request)
    {
        // ... edit a post

        if ($request->isXMLHttpRequest()) {

            $task_name = $request->get("task_name");
            $task_desc = $request->get('task_desc');
            //
            if ($task_name && $task_desc){
                /* Добавляем все в базу */
                $em = $this->getDoctrine()->getManager();

                $task = new Task();

                $task->setName($task_name);

                $task->setDescription($task_desc);

                $task->setStatus(0);

                $em->persist($task);
                // на самом деле выполнить запросы (т.е. запрос INSERT)
                $em->flush();

                $task_id = $task->getId();
                //
                return new JsonResponse( json_encode(array('id' => $task_id,'task' => $task_name,
                        'task_desc' => $task_desc, 'status'=> 0 ),
                    JSON_UNESCAPED_UNICODE) );
            }

        }


        return $this->render('add_task/index.html.twig');
    }

    /**
     * @Route("/edit", methods={"POST"}, name="edit")
     */
    public function edit(Request $request){

        if ($request->isXMLHttpRequest()) {

            $task_id = $request->get('task_id');
            $task_name = $request->get("task_name");
            $task_desc = $request->get('task_desc');
            //
            if ($task_name && $task_desc){
                /* Добавляем все в базу */
                $em = $this->getDoctrine()->getManager();

                $task = new Task();

                $task->setName($task_name);

                $task->setDescription($task_desc);

                $task->setStatus(0);

                $em->persist($task);
                // на самом деле выполнить запросы (т.е. запрос INSERT)
                $em->flush();


                //

            }
            return new JsonResponse( json_encode(array('id' => $task_id,'task' => $task_name,
                    'task_desc' => $task_desc, 'status'=> 0 ),
                JSON_UNESCAPED_UNICODE) );

        }
        return new JsonResponse();

    }
}
