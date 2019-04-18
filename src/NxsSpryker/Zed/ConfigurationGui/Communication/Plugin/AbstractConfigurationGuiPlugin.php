<?php

namespace NxsSpryker\Zed\ConfigurationGui\Communication\Plugin;

use NxsSpryker\Zed\Configuration\Communication\Plugin\ConfigurationValueInterface;
use NxsSpryker\Zed\ConfigurationGui\Communication\Form\ConfigurationValueForm;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Symfony\Component\Form\FormInterface;

/**
 * @method \NxsSpryker\Zed\ConfigurationGui\Communication\ConfigurationGuiCommunicationFactory getFactory()
 */
abstract class AbstractConfigurationGuiPlugin extends AbstractPlugin implements ConfigurationGuiPluginInterface
{
    /**
     * @return \NxsSpryker\Zed\Configuration\Communication\Plugin\ConfigurationValueInterface
     */
    abstract public function getConfigurationValue(): ConfigurationValueInterface;

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getConfigurationValueForm(): FormInterface
    {
        return $this->getFactory()->createConfigurationValueForm(
            $this->getFormType(),
            $this->getFormData(),
            $this->getFormOptions()
        );
    }

    /**
     * @return string
     */
    public function getFormType(): string
    {
        return ConfigurationValueForm::class;
    }

    /**
     * @return array|null
     */
    public function getFormData(): ?array
    {
        $configurationKey = $this->getConfigurationValueKey();

        return [
            $configurationKey => $this->getFactory()->getConfigurationValue($configurationKey)->getValue(),
        ];
    }

    /**
     * @return array
     */
    public function getFormOptions(): array
    {
        return [
            ConfigurationValueForm::CONFIGURATION_FIELD_KEY => $this->getConfigurationValueKey(),
            ConfigurationValueForm::CONFIGURATION_FIELD_LABEL => $this->getConfigurationFieldLabel(),
            'label' => $this->getFormLabel(),
        ];
    }

    /**
     * @return string
     */
    protected function getConfigurationFieldLabel(): string
    {
        return $this->getConfigurationValueKey();
    }

    /**
     * @return string
     */
    public function getConfigurationValueKey(): string
    {
        return $this->getConfigurationValue()->getKey();
    }

    /**
     * @return string
     */
    protected function getFormLabel(): string
    {
        return '';
    }
}
