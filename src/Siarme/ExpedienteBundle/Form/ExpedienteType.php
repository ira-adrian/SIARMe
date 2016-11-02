<?php

namespace Siarme\ExpedienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpedienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('letra', 'text',array('max_length' => 10))
                ->add('numero', 'number')
                ->add('anio', 'number', array('label'  => 'Año'))
                ->add('extracto', 'textarea')
                ->add('observacion')
               // ->add('estado', 'choice', array('choices'   => array('false' => 'INICIAR','true' => 'CONCLUIR' ),
  // 'required'  => true,))
                ->add('agente')
                ->add('clasificacion');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Siarme\ExpedienteBundle\Entity\Expediente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'siarme_expedientebundle_expediente';
    }


}
