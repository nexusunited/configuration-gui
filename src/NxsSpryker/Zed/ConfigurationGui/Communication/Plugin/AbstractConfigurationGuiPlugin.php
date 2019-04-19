<?php

namespace NxsSpryker\Zed\ConfigurationGui\Communication\Plugin;

use NxsSpryker\Zed\Configuration\Communication\Plugin\ConfigurationValueInterface;
use NxsSpryker\Zed\ConfigurationGui\Communication\Form\ConfigurationValueForm;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

/**
 * @method \NxsSpryker\Zed\ConfigurationGui\Communication\ConfigurationGuiCommunicationFactory getFactory()
 */
abstract class AbstractConfigurationGuiPlugin extends AbstractPlugin implements ConfigurationGuiPluginInterface
{
    const COLLECTION_FORMTYPE_CLASS = 'collection_formtype';
    const DEFAULT_FIELD_TYPE = TextType::class;
    const DEFAULT_FIELD_LABEL = '';
    const DEFAULT_IS_COLLECTION = false;

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
            $configurationKey => $this->getConfigurationValueData(),
        ];
    }

    /**
     * @return array
     */
    public function getFormOptions(): array
    {
        $options = [
            ConfigurationValueForm::CONFIGURATION_FIELD_KEY => $this->getConfigurationValueKey(),
            ConfigurationValueForm::CONFIGURATION_FIELD_LABEL => $this->getConfigurationFieldLabel(),
            ConfigurationValueForm::CONFIGURATION_FIELD_TYPE => $this->getFieldType(),
            ConfigurationValueForm::CONFIGURATION_FIELD_OPTIONS => $this->getFieldOptions(),
        ];

        return $options;
    }

    /**
     * @return array
     */
    protected function getFieldOptions(): array
    {
        $options = [
            'label' => $this->getFormLabel(),
            'empty_data' => $this->getEmptyData(),
        ];

        if ($this->isCollection()) {
            $options = $this->addCollectionClassOption($options);
        }

        return $options;
    }

    /**
     * @return mixed
     */
    protected function getEmptyData()
    {
        return '';
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function addCollectionClassOption(array $options): array
    {
        $existingClass = '';
        if (isset($options['attr']['class']) && $options['attr']['class']) {
            $existingClass = $options['attr']['class'];
        }

        $options['attr']['class'] = \sprintf(
            '%s %s',
            $existingClass,
            self::COLLECTION_FORMTYPE_CLASS
        );

        return $options;
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
     * @return mixed
     */
    protected function getConfigurationValueData()
    {
        return $this->getFactory()
            ->getConfigurationValue($this->getConfigurationValueKey())
            ->getValue();
    }

    /**
     * @return string
     */
    protected function getFormLabel(): string
    {
        return self::DEFAULT_FIELD_LABEL;
    }

    /**
     * @return string
     */
    protected function getFieldType(): string
    {
        return self::DEFAULT_FIELD_TYPE;
    }

    /**
     * @return bool
     */
    protected function isCollection(): bool
    {
        return self::DEFAULT_IS_COLLECTION;
    }
}
