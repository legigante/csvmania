<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Feeling;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('name', TextType::class, [
                'label' => 'entity.name'
            ])
            ->add('priority', ChoiceType::class, [
                'choices'  => [
                    'task.priority.1' => 1,
                    'task.priority.2' => 2,
                    'task.priority.3' => 3,
                ],
                'data' => 2,
                'label' => 'task.priority.label'
            ])
            ->add('language', ChoiceType::class, [
                'choices'  => [
                    'menu.language.en' => 'en',
                    'menu.language.es' => 'es',
                    'menu.language.fr' => 'fr',
                ],
                'data' => 'en',
                'label' => 'menu.language.label'
            ])
            ->add('deadline', DateType::class, [
                'label' => 'task.deadline',
                'data' => new \DateTime(date('Y-m-d',mktime(0,0,0,date('m'),date('d')+14,date('Y'))))
            ])
            ->add('nb_answer_needed', IntegerType::class, [
                'attr' => ['min' => 1],
                'label' => 'task.nb_answer_needed',
                'data' => 1
            ])
            ->add('file', CsvType::class, [
                'label' => 'task.file',
                'mapped' => false
            ])
            ->add('fields', FieldsType::class, [
                'class' => Feeling::class,
                'choice_label' => function ($f) {
                    return $f->getLabel();
                },
                'multiple' => true,
                'label' => 'task.fields',
                'mapped' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'task.add'
            ]);

    }

}