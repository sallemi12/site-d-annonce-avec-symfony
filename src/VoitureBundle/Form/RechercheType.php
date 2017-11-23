<?php

namespace VoitureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RechercheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $Kilometrage=array();
 
        $maxkilometrage=100000;
        $maxPrixValue = 100000; 
        $prix = array();
        $maxanne = 2017; 
        $anne=array();
        foreach(range(0, $maxPrixValue, 10000) as $i){

        $prix[$i] = $i;

        }
        foreach(range(0, $maxkilometrage, 10000) as $i){

        $Kilometrage[$i] = $i;

        }
        foreach(range(1990, $maxanne, 1) as $i){

        $date[$i] = $i;

        }
         $builder->add('marque',null,array('required'=>true,'placeholder' => ' Marque'))
        ->add('modele',null, array('required'=>false ,'mapped'=>false))
        ->add('carburant',null,array('required'=>false, 'placeholder' => 'Type de Carburant'))
        ->add('transmission',null,array('required'=>false , 'placeholder' => 'Type de Transmission'))
        ->add('prix_min',ChoiceType::class, array('choices' => $prix,'required'=>false,'label'=>'Prix Min', 'placeholder' => '0' ,'mapped'=>false))
        ->add('prix_max',ChoiceType::class, array('choices' => $prix,'required'=>false,'label'=>'Prix Max', 'placeholder' => 'Jusqu a','mapped'=>false))  
        ->add('region',null,array('required'=>false , 'placeholder' => 'Tous Regions')) 
        ->add('Kilometrage',ChoiceType::class, array('choices' => $Kilometrage,'required'=>false,'label'=>'Kilometrage'))   
        ->add('date',ChoiceType::class, array('choices' => $date,'required'=>false,'label'=>'date', 'placeholder' => 'date de mise en circulation' ,'mapped'=>false))

         ;



                    
                
            
    }
    
   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VoitureBundle\Entity\Voiture'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'VoitureBundle_Voiture';
    }
    public function getNom(){
        return 'rechercher_formulaire';
    }


}
