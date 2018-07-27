<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 27/07/2018
 * Time: 10:51
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class CVFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('mission')
            ->add('disponibilite')
            ->add('fichier', FileType::class)
            /*->add('categorie')
            ->add('technologie')*/
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\CV'
        ]);
    }
}