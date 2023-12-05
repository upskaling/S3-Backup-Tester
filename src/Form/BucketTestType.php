<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Bucket;
use App\Entity\BucketTest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BucketTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //  Un temps en seconde Par rapport à la date d'aujourd'hui Pour lequel le fichier est encore valide
            ->add('interval', IntegerType::class, [
                'label' => 'Interval (in seconds)',
                'help' => 'ex: 3600 = 1 hour',
            ])
            ->add('Bucket', EntityType::class, [
                'class' => Bucket::class,
                'choice_label' => 'name',
                'disabled' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BucketTest::class,
        ]);
    }
}
