<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('price', IntegerType::class)
            ->add('description', TextType::class)
            // ->add('statusSold', TextType::class)
            ->add('photoFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
        ])
            ->add('material', ChoiceType::class, [
                'choices'  =>
                [
                'bois' => 'bois',
                'métal' => 'métal',
                'tissus' => 'tissus',
                'plastique' => 'plastique',
                'verre' => 'verre',
                'PVC' => 'PVC'
                ],
                'multiple' => true,
                'expanded' => true])
            ->add('categoryRoom', ChoiceType::class, [
                'choices'  =>
                [
                'Bureau' => 'Bureau',
                'Chambre' => 'Chambre',
                'Salon' => 'Salon',
                'Cuisine' => 'Cuisine',
                'Salle à manger' => 'Salle à manger'
                ],
                'multiple' => true,
                'expanded' => true])
            ->add('color', ChoiceType::class, [
                'choices'  =>
                [
                'noir' => "#000000",
                'blanc' => '#FFFFFF',
                'bleu' => "#0000FF",
                'rouge' => '#FF0000',
                'vert' => '00561b'
                ],
                'multiple' => true,
                'expanded' => true])
            ->add('state', TextType::class)
            ->add('showPhoneUser', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,]])
            ->add('showEmailUser', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,]])
            // ->add('user', null, ['choice_label' => 'pseudo'])
            ->add('categoryItem', null, ['choice_label' => 'title'])
            // ->add('cart', null, ['choice_label' => 'id_user'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
