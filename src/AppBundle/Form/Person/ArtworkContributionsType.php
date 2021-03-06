<?php

/*
 * To change this license header, choose License Headers in Artwork Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form\Person;

use AppBundle\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtworkContributionsType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $person = $options['person'];
        $builder->add('artworkContributions', CollectionType::class, array(
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'entry_type' => ArtworkContributionType::class,
            'entry_options' => array(
                'person' => $person,
            ),
            'label' => 'Contribution',
            'attr' => array(
                'group_class' => 'collection',
            ),
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Person::class,
            'person' => null,
        ));
    }
    
}
