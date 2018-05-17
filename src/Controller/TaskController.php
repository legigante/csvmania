<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

use App\Entity\Task;
use App\Entity\Token;
use App\Form\Type\TaskType;

class TaskController extends Controller
{

    /**
     * @Route("/tasks", name="tasks")
     * @return Response
     */
    public function index(AuthorizationCheckerInterface $authChecker)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $rep = $this->getDoctrine()->getRepository(Task::class);

        // get assigned tasks to do
        $todoTasks = $rep->getToDoTasks($user->getId());

        // get assigned tasks done
        $tovalidateTasks = [];
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            $tovalidateTasks = $rep->getToValidateTasks($user->getId());
        }

        return $this->render('task/index.html.twig', array(
            'todotasks' => $todoTasks,
            'tovalidatetasks' => $tovalidateTasks
        ));
    }






    /**
     * @Route("/task/{id}", name="show_task", requirements={"id"="\d+"})
     * @param $id
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show($id){

        $rep = $this->getDoctrine()->getRepository(Task::class);

        // get % prog user
        $progressionDone = $rep->getTaskProgressionDone($id)[1];
        // get % prog admin
        $progressionValidated = $rep->getTaskProgressionValidated($id)[1];
        // get task
        $task = $rep->find($id);
        // get tokens
        $tokens = $task->getTokens();

        return $this->render('task/show.html.twig', array(
            "task"=>$task,
            "tokens"=>$tokens,
            "progressionDone"=>$progressionDone,
            "progressionValidated"=>$progressionValidated
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
    public function createAction(Request $request){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // on check le fichier csv
            $csvName = uniqid() . '.csv';
            $csvFolder = $_SERVER['DOCUMENT_ROOT'] . '/../files/csv/';
            $csvContent = base64_decode($form['file']->getData());
            $rows = explode("\n",$csvContent);
                // nb colonne
                // entête ?

            // on créé le fichier csv
            $fp = fopen($csvFolder.$csvName, 'w');
            $i = 1;
            while($i < count($rows)){
                if($rows[$i] != ''){
                    fwrite($fp, $rows[$i] . "\n");
                    $cols = explode(';',$rows[$i]);
                    $token = new Token();
                    $token->setLabel($cols[0]);
                    $token->setTask($task);
                    $em->persist($token);
                }
                $i++;
            }
            fclose($fp);

            // on complère l'entité
            $task->setPath($csvName);
            $task->setCategory(1);
            if($form['assigned_to']->getData()){
                $task->setAssignedAt(new \DateTime());
            }
            $task->setCreatedBy($user);
            $task->setCreatedAt(new \DateTime());

            // on stock en base
            $em->persist($task);
            $em->flush();

            // on retourne à l'accueil
            return $this->redirectToRoute('admin/tasks');

        }else{
            // on affiche les erreurs
            return $this->render('task/add.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

}