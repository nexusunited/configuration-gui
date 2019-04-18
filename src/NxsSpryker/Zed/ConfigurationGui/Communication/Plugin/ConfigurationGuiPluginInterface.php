<?php

namespace NxsSpryker\Zed\ConfigurationGui\Communication\Plugin;

use Symfony\Component\Form\FormInterface;

interface ConfigurationGuiPluginInterface
{
    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getConfigurationValueForm(): FormInterface;
}
