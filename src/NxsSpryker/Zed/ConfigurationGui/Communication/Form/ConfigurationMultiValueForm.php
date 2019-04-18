<?php

namespace NxsSpryker\Zed\ConfigurationGui\Communication\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationMultiValueForm extends AbstractType
{
    public const CONFIGURATION_VALUE_FORMS = 'CONFIGURATION_VALUE_FORMS';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var \NxsSpryker\Zed\ConfigurationGui\Communication\Plugin\AbstractConfigurationGuiPlugin[] $configurationValuePlugins */
        $configurationValuePlugins = $options[self::CONFIGURATION_VALUE_FORMS];
        foreach ($configurationValuePlugins as $configurationValuePlugin) {
            $builder->add(
                $configurationValuePlugin->getConfigurationValueKey(),
                $configurationValuePlugin->getFormType(),
                \array_merge($configurationValuePlugin->getFormOptions(), ['label' => false])
            );
        }
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
                self::CONFIGURATION_VALUE_FORMS => [],
            ]
        );
    }
}
