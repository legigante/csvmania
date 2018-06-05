<?php
namespace App\Controller;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use App\Entity\Assignment;
use App\Entity\Answer;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\Type\FeelingType;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AssignmentController extends Controller
{


    /**
     * page de saisie tâche
     * @Route("/assignment/fill/{id}", name="fill_assignment", requirements={"id"="\d+"})
     * @param $id
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function fill($id, SessionInterface $session){

        // task repository
        $repContent = $this->getDoctrine()->getRepository(Assignment::class);

        // get next entry
        $nextContent = $repContent->getNextEntry($id);

        if(count($nextContent) == 0){
            // no more entry => go to tasks
            $session->getFlashBag()->add('danger', 'entity.Assignment.flash.no_more_entry');
            return $this->redirectToRoute('tasks');
        }else{
            $nextContent = $nextContent[0];

            // on génère le formulaire
            $answer = new Answer();
            $formBuilder = $this->createFormBuilder($answer)
                ->add('assignment_id', IntegerType::class, [
                    'attr' => ['style' => 'display: none;'],
                    'mapped' => false,
                    'label' => false
                ])
                ->add('content_id', IntegerType::class, [
                    'attr' => ['style' => 'display: none;'],
                    'mapped' => false,
                    'label' => false
                ])
                ->add('field_id', IntegerType::class, [
                    'attr' => ['style' => 'display: none;'],
                    'mapped' => false,
                    'label' => false
                ]);

            // champs valeur selon format field
            if($nextContent['format'] == 1){
                $formBuilder->add('value', ChoiceType::class, [
                    'choices'  => [
                        'Yes' => 1,
                        'No' => 0
                    ],
                    'label' => $nextContent['label']
                ]);
            }elseif($nextContent['format'] == 2){
                $formBuilder->add('value', IntegerType::class, [
                    'label' => $nextContent['label'],
                    'attr' => ['min' => 1]
                ]);
            }elseif($nextContent['format'] == 3){
                $formBuilder->add('value', FeelingType::class, [
                    'label' => $nextContent['label']
                ]);
            }else{
                // nouveau format ?
                $session->getFlashBag()->add('danger', 'entity.Assignment.flash.bad_format');
                return $this->redirectToRoute('tasks');
            }

            // submit
            $formBuilder->add('save', SubmitType::class);
            $form = $formBuilder->getForm();

            // on affiche le formulaire
            return $this->render('assignment/fill.html.twig', [
                'form' => $form->createView(),
                'data' => $nextContent
            ]);
        }
    }




}
