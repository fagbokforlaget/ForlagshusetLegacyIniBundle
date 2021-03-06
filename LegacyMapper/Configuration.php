<?php

namespace Forlagshuset\LegacyIniBundle\LegacyMapper;

use eZ\Publish\Core\MVC\Legacy\LegacyEvents;
use eZ\Publish\Core\MVC\Legacy\Event\PreBuildKernelEvent;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Configuration implements EventSubscriberInterface
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    protected $configResolver;

    /**
     * @var array
     */
    protected $enabledLegacySettings;

    public function __construct(ConfigResolverInterface $configResolver, array $enabledLegacySettings)
    {
        $this->configResolver = $configResolver;
        $this->enabledLegacySettings = $enabledLegacySettings;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            LegacyEvents::PRE_BUILD_LEGACY_KERNEL => array('onBuildKernel', 64),
        );
    }

    /**
     * Adds settings to the parameters that will be injected into the legacy kernel.
     *
     * @param \eZ\Publish\Core\MVC\Legacy\Event\PreBuildKernelEvent $event
     */
    public function onBuildKernel(PreBuildKernelEvent $event)
    {
        $injectedSettings = array();
        if ($this->configResolver->hasParameter('injected_settings', 'forlagshuset_legacy_ini'))
        {
            $injectedSettings = $this->configResolver->getParameter('injected_settings', 'forlagshuset_legacy_ini');
        }

        $injectedMergeSettings = array();
        if ($this->configResolver->hasParameter('injected_merge_settings', 'forlagshuset_legacy_ini'))
        {
            $injectedMergeSettings = $this->configResolver->getParameter('injected_merge_settings', 'forlagshuset_legacy_ini');
        }

        $formattedInjectedSettings = array();
        $formattedInjectedMergeSettings = array();

        foreach ($this->enabledLegacySettings as $legacyIniName) {
            if (!empty($injectedSettings[$legacyIniName]) && is_array($injectedSettings[$legacyIniName])) {
                foreach ($injectedSettings[$legacyIniName] as $legacyIniValueName => $legacyIniValue) {
                    if (!is_string($legacyIniValueName)) {
                        continue;
                    }

                    $formattedInjectedSettings[$legacyIniName . '/' . $legacyIniValueName] = $legacyIniValue;
                }
            }

            if (!empty($injectedMergeSettings[$legacyIniName]) && is_array($injectedMergeSettings[$legacyIniName])) {
                foreach ($injectedMergeSettings[$legacyIniName] as $legacyIniValueName => $legacyIniValue) {
                    if (!is_string($legacyIniValueName)) {
                        continue;
                    }

                    if (is_array($legacyIniValue)) {
                        $formattedInjectedMergeSettings[$legacyIniName . '/' . $legacyIniValueName] = $legacyIniValue;
                    }
                }
            }
        }

        $event->getParameters()->set(
            'injected-settings',
            $formattedInjectedSettings + (array)$event->getParameters()->get('injected-settings')
        );

        $event->getParameters()->set(
            'injected-merge-settings',
            $formattedInjectedMergeSettings + (array)$event->getParameters()->get('injected-merge-settings')
        );
    }
}
