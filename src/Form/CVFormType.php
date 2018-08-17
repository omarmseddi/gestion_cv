<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 27/07/2018
 * Time: 10:51
 */

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\categorie;
use App\Entity\technologie;


class CVFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('mission')
            ->add('disponibilite')
            ->add('categorie',EntityType::class,['class'=>categorie::class])
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
                    ])]]);

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