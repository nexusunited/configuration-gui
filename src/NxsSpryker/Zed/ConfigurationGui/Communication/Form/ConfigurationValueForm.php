<?php

namespace NxsSpryker\Zed\ConfigurationGui\Communication\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationValueForm extends AbstractType
{
    public const CONFIGURATION_FIELD_KEY = 'CONFIGURATION_FIELD_KEY';
    public const CONFIGURATION_FIELD_LABEL = 'CONFIGURATION_FIELD_LABEL';
    public const FORM_NAME = 'FORM_NAME';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addConfigurationFormField($builder, $options);
        $this->addModelTransformer($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addConfigurationFormField(FormBuilderInterface $builder, array $options): self
    {
        $builder->add(
            $this->getFieldName($options),
            $this->getFieldType(),
            $this->getFieldOptions($options)
        );

        return $this;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function getFieldOptions(array $options): array
    {
        return [
            'label' => $options[self::CONFIGURATION_FIELD_LABEL],
        ];
    }

    /**
     * @param array $options
     *
     * @return string
     */
    protected function getFieldName(array $options): string
    {
        return $options[self::CONFIGURATION_FIELD_KEY];
    }

    /**
     * @return string
     */
    protected function getFieldType(): string
    {
        return TextType::class;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addModelTransformer(FormBuilderInterface $builder): void
    {
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                self::CONFIGURATION_FIELD_KEY => '',
                self::CONFIGURATION_FIELD_LABEL => '',
            ]
        );
    }
}
