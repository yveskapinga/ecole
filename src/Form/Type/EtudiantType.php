<?php

namespace App\Form\Type;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',TextType::class,['attr'=>['placeholder'=>"nom",'class'=>'form-control']])
        ->add('prenom',TextType::class,['attr'=>['placeholder'=>"prenom",'class'=>'form-control']])
        ->add('email',EmailType::class,['attr'=>['placeholder'=>"exemple@exmple.fr",'class'=>'form-control']])
        ->add('photo',TextType::class,['attr'=>['placeholder'=>"photo",'class'=>'form-control']])
        ->add('password',PasswordType::class,['attr'=>['placeholder'=>"password",'class'=>'form-control']])
        ->add('dateDeNaissance',DateType::class,['attr'=>['class'=>'date']])
        ->add('save',SubmitType::class,['label'=>'creer un compte'],['attr'=>['class'=>'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Etudiant::class,
        ]);
    }
}
