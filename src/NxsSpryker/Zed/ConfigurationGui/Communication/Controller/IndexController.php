<?php

namespace NxsSpryker\Zed\ConfigurationGui\Communication\Controller;

use Generated\Shared\Transfer\ConfigurationTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \NxsSpryker\Zed\ConfigurationGui\Communication\ConfigurationGuiCommunicationFactory getFactory()
 */
class IndexController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request): array
    {
        $configurations = $this->getFactory()->getConfigurationGuiPlugins();
        $configurationFormViews = [];

        foreach ($configurations as $configuration) {
            $configurationForm = $configuration->getConfigurationValueForm();
            $configurationForm->handleRequest($request);
            $this->handleConfigurationForm($configurationForm);

            $configurationFormViews[] = $configuration->getConfigurationValueForm()->createView();
        }

        return $this->viewResponse(
            [
                'configurationForms' => $configurationFormViews,
            ]
        );
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $configurationForm
     *
     * @return void
     */
    protected function handleConfigurationForm(FormInterface $configurationForm): void
    {
        if ($configurationForm->isSubmitted() && $configurationForm->isValid()) {
            $this->handleConfigurationUpdate($configurationForm);
        }
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $configurationForm
     *
     * @return void
     */
    protected function handleConfigurationUpdate(FormInterface $configurationForm): void
    {
        foreach ($configurationForm->getData() as $key => $value) {
            $this->setConfigurationValue($key, $value);
        }
    }

    /**
     * @param string $configurationValueKey
     * @param mixed $configurationValue
     *
     * @return void
     */
    protected function setConfigurationValue(string $configurationValueKey, $configurationValue): void
    {
        $configurationTransfer = (new ConfigurationTransfer())
            ->setKey($configurationValueKey)
            ->setValue($configurationValue);
        $this->getFactory()->getConfigurationFacade()->setConfiguration($configurationTransfer);
    }
}
