<?php

namespace Oro\Bundle\FilterBundle\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoiceFilterType extends AbstractType
{
    const TYPE_CONTAINS = 1;
    const TYPE_NOT_CONTAINS = 2;
    const NAME = 'oro_type_choice_filter';

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return FilterType::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = array(
            self::TYPE_CONTAINS => $this->translator->trans('label_type_contains', array(), 'OroFilterBundle'),
            self::TYPE_NOT_CONTAINS => $this->translator->trans('label_type_not_contains', array(), 'OroFilterBundle'),
        );

        $resolver->setDefaults(
            array(
                'field_type' => 'choice',
                'field_options' => array('choices' => array()),
                'operator_choices' => $choices,
            )
        );
    }
}
