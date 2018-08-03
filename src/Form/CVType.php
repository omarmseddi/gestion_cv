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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
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
            ->add('fichier', FileType::class,[
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'aapplication/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                            'application/vnd.ms-word.document.macroEnabled.12,',
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF or word file!',
                    ])]])
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