<?php

namespace App\Controller;

use PhpParser\Error;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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
use Doctrine\DBAL\DriverManager as DriverManager;

class IndexController extends Controller
{

    private function checkStrings($arg){
            if ($arg){
                $arg = str_replace(" ", "", $arg);
            }
            return $arg;
    }

    private function deleteTags($str){
        return strip_tags($str);
    }

    private function checkMaxSize(&$str, $length = 15){
        if (strlen($str) > $length)
            return false;

        return true;
    }

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

                $task_name = $this->checkStrings($task_name);
                $task_desc = $this->checkStrings($task_desc);

                /* Check Strings */
                $task_name = $this->deleteTags($task_name);
                $task_desc = $this->deleteTags($task_desc);

                if (!$this->checkMaxSize($task_name, 16) && ($this->checkMaxSize($task_desc, 128)))
                    throw new Exception();
                /* End of check*/

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

        $id = $request->get('edit_task_id');

        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $new_name = $request->get('edit_task_name');
        $new_description = $request->get('edit_task_description');
        $new_status = $request->get('edit_sel');

        //die(iconv_strlen($new_name));
        if (! ( $this->checkMaxSize($new_name, 16) || ($this->checkMaxSize($new_description, 128)) ))
            return $this->redirectToRoute('index');

        $new_name = $this->checkStrings($new_name);
        $new_description = $this->checkStrings($new_description);
        $new_name = $this->deleteTags($new_name);
        $new_description = $this->deleteTags($new_description);



        $task->setName($new_name);
        $task->setDescription($new_description);
        $task->setStatus($new_status);

        $entityManager->persist($task);
        $entityManager->flush();


        if (!$task) {
            throw $this->createNotFoundException(
                'No task found for id '.$id
            );
        }


        return $this->redirectToRoute('index');

    }

    /**
     * @Route("/del", methods={"POST"}, name="del")
     */
    public function deleteTask(Request $request){

        if ($request->isXMLHttpRequest()) {

            $task_id = $request->get("id");
            //
            if ($task_id){

                $repository = $this->getDoctrine()->getRepository(Task::class);

                $em = $this->getDoctrine()->getManager();

                $task = $repository->find($task_id);


                $em->remove($task);
                $em->flush();

                //
                return new JsonResponse( );
            }
        }
        return new JsonResponse( );
    }
}
