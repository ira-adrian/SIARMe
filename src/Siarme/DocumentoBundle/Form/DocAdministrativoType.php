<?php

namespace Siarme\DocumentoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocAdministrativoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaDocumento', 'date')
                ->add('dirigidoA', 'textarea', array( 'required' => false ))
                ->add('estado')
                ->add('texto', 'ckeditor')
                //->add('fechaCreacion')
                //->add('usuario')
                //->add('tramite') 
                       ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siarme\DocumentoBundle\Entity\DocAdministrativo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'siarme_documentobundle_docadministrativo';
    }


}
