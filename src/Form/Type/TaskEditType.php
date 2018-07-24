<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('priority', ChoiceType::class, [
                'choices'  => [
                    'entity.Task.priority1' => 1,
                    'entity.Task.priority2' => 2,
                    'entity.Task.priority3' => 3,
                ],
                'data' => $options['data']->getPriority(),
                'label' => 'entity.Task.priority',
                'attr'=>[
                    'class'=>'mpWrite d-none',
                    'data-prop'=>'priority'
                ]
            ])
            ->add('deadline', DateType::class, [
                'label' => 'entity.Task.deadline',
                'data' => $options['data']->getDeadline(),
                'attr'=>[
                    'class'=>'mpWrite d-none',
                    'data-prop'=>'deadline'
                ]
            /*])
            ->add('save', SubmitType::class, [
                'label' => 'entity.Task.add',
                'attr'=>[
                    'class'=>'d-none'
                ]*/
            ]);
    }

}