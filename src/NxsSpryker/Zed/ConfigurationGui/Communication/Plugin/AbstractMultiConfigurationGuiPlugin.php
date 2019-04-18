<?php

namespace NxsSpryker\Zed\ConfigurationGui\Communication\Plugin;

use NxsSpryker\Zed\ConfigurationGui\Communication\Form\ConfigurationMultiValueForm;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Symfony\Component\Form\FormInterface;

/**
 * @method \NxsSpryker\Zed\ConfigurationGui\Communication\ConfigurationGuiCommunicationFactory getFactory()
 */
abstract class AbstractMultiConfigurationGuiPlugin extends AbstractPlugin implements ConfigurationGuiPluginInterface
{
    /**
     * @return \NxsSpryker\Zed\ConfigurationGui\Communication\Plugin\AbstractConfigurationGuiPlugin[]
     */
    abstract public function getConfigurationValues(): array;

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getConfigurationValueForm(): FormInterface
    {
        $form = $this->getFactory()->createConfigurationMultiValueForm(
            $this->getFormType(),
            $this->getFormData(),
            $this->getFormOptions()
        );

        return $form;
    }

    /**
     * @return string
     */
    protected function getFormType(): string
    {
        return ConfigurationMultiValueForm::class;
    }

    /**
     * @return array|null
     */
    protected function getFormData(): ?array
    {
        $data = [];
        foreach ($this->getConfigurationValues() as $plugin) {
            $data[] = $plugin->getFormData();
        }

        return $data;
    }

    /**
     * @return array
     */
    protected function getFormOptions(): array
    {
        return [
            ConfigurationMultiValueForm::CONFIGURATION_VALUE_FORMS => $this->getConfigurationValues(),
            'label' => $this->getFormLabel(),
        ];
    }

    /**
     * @return string
     */
    abstract protected function getFormLabel(): string;
}
