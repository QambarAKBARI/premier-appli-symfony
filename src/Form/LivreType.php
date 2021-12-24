<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('prix', NumberType::class, [
                'attr' => ['class' => 'form-control',
                            'rows' => 10]
            ])
            ->add('resume', TextareaType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('nbPages', NumberType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateParution', DateType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('auteur', EntityType::class, [
                
                'attr' => ['class' => 'form-control'],
            
                'class' => Auteur::class,
                'choice_label' => function($auteur) {
                    return $auteur;
                }
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
