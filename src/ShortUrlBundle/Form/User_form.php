<?php

namespace ShortUrlBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User_form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('longUrl')
            ->add('shortUrl', null,  array(
                'required' => false
            ))
            ->add('save', SubmitType::class);

            // create checkbox
            //->add('agreeTerms', CheckboxType::class, array('mapped' => false));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ShortUrlBundle\Entity\Urls_table',

        ));
    }

    public function getBlockPrefix()
    {
        return 'short_url_bundleuser_form';
    }
}

/*
'required' => false,
            'label'  => 'Due Date',
*/