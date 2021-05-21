<?php

namespace App\Form;
use App\Entity\Magasin;

use App\Entity\Vendeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Salaire')
            ->add('magasin',EntityType::class,['class' => magasin::class,
            'choice_label' => 'nom',
            'label' => 'Magasin']);
        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vendeur::class,
        ]);
    }
}
