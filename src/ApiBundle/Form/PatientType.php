<?php

namespace ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('firstname', TextType::class, array('description' => "Prénom du patient"))
           ->add('lastname', TextType::class, array('description' => "Nom du patient"))
           ->add('adresse', TextType::class, array('description' => "Adresse du patient"))
           ->add('telephone', TextType::class, array('description' => "Telephone du patient"))
           ->add('dateNaissance', TextType::class, array('description' => "Date de naissance du patient"));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ApiBundle\Entity\Patient',
            'csrf_protection' => false // Dsactiver la protection csrf_protection ds une API
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ApiBundle_patient';
    }


}
