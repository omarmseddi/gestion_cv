<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27/07/2018
 * Time: 12:19
 */

namespace App\Form;


use App\Entity\Categorie;
use App\Entity\CV;
use App\Entity\Technologie;
use function PHPSTORM_META\type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\CategorieType;

class CVType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("nom",TextType::class)
                ->add('prenom',TextType::class)
                ->add('idSp')
                ->add('type',TextType::class)
                ->add('categorie', CategorieType::class)

                ->add('mission', ChoiceType::class,  array(
                    'choices'  => array(
                        'Oui' => true,
                        'Non' => false),
                    'expanded'=>true,
                    'multiple' => false,
                    'error_bubbling' => false))
                ->add('disponibilite', ChoiceType::class, array(
                    'choices'  => array(
                        'Oui' => true,
                        'Non' => false),
                    'expanded'=>true,
                    'multiple' => false,
                    'error_bubbling' => false))
            ->add('technologies', CollectionType::class, array(
                'entry_type' => TechnologieType::class,
                'allow_add'    => true,
                'prototype' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
            ));

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class"=>CV::class,
            'csrf_protection' => false,
            "allow_extra_fields" => true

        ]);
    }
}