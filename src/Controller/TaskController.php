<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Task;
use App\Entity\User;

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

        $formFactory = Forms::createFormFactory();

        $task = new Task();

        $form = $formFactory->createBuilder()
            ->add('name', TextType::class, [
                'label' => 'task.name'
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'task.category',
                'choices' => [
                    'task.cat1' => 1,
                    'task.cat2' => 2
                ]
            ])
            ->add('deadline', DateType::class, [
                'label' => 'task.deadline'
            ])
            ->getForm();

        return $this->render('task/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Method("post")
     * @Route("/task/add", name="create_task")
     * @return Response
     */
    public function createAction(){
        return $this->render('task/add.html.twig', array(

        ));
    }

}