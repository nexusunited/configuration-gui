<?php

namespace NxsSpryker\Zed\ConfigurationGui\Communication;

use Generated\Shared\Transfer\ConfigurationTransfer;
use NxsSpryker\Zed\Configuration\Business\ConfigurationFacadeInterface;
use NxsSpryker\Zed\ConfigurationGui\ConfigurationGuiDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

class ConfigurationGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \NxsSpryker\Zed\ConfigurationGui\Communication\Plugin\AbstractConfigurationGuiPlugin[]
     */
    public function getConfigurationGuiPlugins(): array
    {
        return $this->getProvidedDependency(ConfigurationGuiDependencyProvider::CONFIGURATION_GUI_PLUGINS);
    }

    /**
     * @param string $formType
     * @param mixed|null $data
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface|\NxsSpryker\Zed\ConfigurationGui\Communication\Form\ConfigurationValueForm
     */
    public function createConfigurationValueForm(string $formType, $data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create($formType, $data, $options);
    }

    /**
     * @param string $formType
     * @param mixed|null $data
     * @param array|null $options
     *
     * @return \Symfony\Component\Form\FormInterface|\NxsSpryker\Zed\ConfigurationGui\Communication\Form\ConfigurationMultiValueForm
     */
    public function createConfigurationMultiValueForm(string $formType, $data = null, ?array $options = null): FormInterface
    {
        return $this->getFormFactory()->create($formType, $data, $options);
    }

    /**
     * @param string $key
     *
     * @return \Generated\Shared\Transfer\ConfigurationTransfer
     */
    public function getConfigurationValue(string $key): ConfigurationTransfer
    {
        return $this->getConfigurationFacade()->getConfiguration($key);
    }

    /**
     * @return \NxsSpryker\Zed\Configuration\Business\ConfigurationFacadeInterface
     */
    public function getConfigurationFacade(): ConfigurationFacadeInterface
    {
        return $this->getProvidedDependency(ConfigurationGuiDependencyProvider::CONFIGURATION_FACADE);
    }
}
