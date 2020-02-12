<?php
namespace Lrotherfield\Component\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Lrotherfield\Component\Form\DataTransformer\EntityToIdentifierTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class HiddenEntityType
 *
 * Render an entity as a hidden field using the identifier field "id"
 * transformed using the Entity to Int transformer
 *
 * @package Lrotherfield\Bundle\TestBundle\Form\Type
 * @author Luke Rotherfield <luke@lrotherfield.com>
 */
class HiddenEntityType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Add the data transformer to the field setting the entity repository
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityTransformer = new $options['transformer']($this->em);
        $entityTransformer->setEntityRepository($options['class']);
        $builder->addModelTransformer($entityTransformer);
    }

    /**
     * Require the entity repository option to be set on the field
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
               'transformer' => 'Lrotherfield\Component\Form\DataTransformer\EntityToIdentifierTransformer'
            ));
        $resolver->setRequired(
            array(
                "class"
            )
        );
    }

    /**
     * Require the entity repository option to be set on the field
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * Set the parent form type to Symfony core HiddenType
     *
     * TODO: when drop Symfony 2.x support, add use statement above
     *       for HiddenType core class and return HiddenType::class
     *       here instead of path string
     *
     * @return string
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\HiddenType';
    }

    /**
     * Symfony 2.x version of getBlockPrefix()
     *
     * TODO: when drop Symfony 2.x support, remove this method
     *
     * @return string
     */
    public function getName()
    {
        return 'hidden_entity';
    }

    /**
     * Prefix form input field id attributes with 'hidden_entity'
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'hidden_entity';
    }
}
