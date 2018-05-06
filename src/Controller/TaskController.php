<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Task;
use App\Form\Type\TaskType;

class TaskController extends Controller
{

    /**
     * @Route("/tasks", name="tasks")
     * @return Response
     */
    public function index()
    {
        return $this->render('task/index.html.twig', array(

        ));
    }


    /**
     * @Method("get")
     * @Route("/task/add", name="add_task")
     * @return Response
     */
    public function addAction(){

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        return $this->render('task/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Method("post")
     * @Route("/task/add", name="create_task")
     * @return Response
     */
    public function createAction(Request $request, ValidatorInterface $validator){

        //
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            echo 'oui';
        }else{
            echo 'non';
        }



        echo 'salut';
        exit();
        return $this->render('task/add.html.twig', array(

        ));
    }

}