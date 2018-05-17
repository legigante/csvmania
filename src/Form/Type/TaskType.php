<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\User;


class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('name', TextType::class, [
                'label' => 'entity.name'
            ])
            ->add('assigned_to', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.first_name', 'ASC')
                        ->orderBy('u.last_name', 'ASC');
                },
                'choice_label' => function ($u) {
                    return $u->getFirstName() . ' ' . $u->getLastName();
                },
                'label' => 'task.assigned_to',
                'required' => false
            ])
            ->add('deadline', DateType::class, [
                'label' => 'task.deadline'
            ])
            ->add('file', CsvType::class, [
                'label' => 'task.file',
                'mapped' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'task.add'
            ]);

    }

}