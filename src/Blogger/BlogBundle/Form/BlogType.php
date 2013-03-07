<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MinLength;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Título',
            ))
            ->add('author', 'text', array(
                'label' => 'Autor'
            ))
            ->add('blog', 'textarea', array(
                'label' => 'Post',
                'constraints' => array(
                    new NotBlank(),
                    new MinLength(3),
            ),
            ))
            //->add('image')
            ->add('tags')
            //->add('created')
            //->add('updated')
            //->add('slug')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\Blog'
        ));
    }

    public function getName()
    {
        return 'blogger_blogbundle_blogtype';
    }
}
