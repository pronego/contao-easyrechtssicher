<?php
/**
 * Easyrechtssicher integration for Contao Open Source CMS.
 *
 * @author    Dr. Manuel Lamotte-Schubert <mls@pronego.com>
 * @copyright 2024, PRONEGO - https://www.pronego.com
 * @license   LGPL-3.0-or-later
 */
namespace Pronego\EasyrechtssicherBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class EasyrechtssicherBundle extends AbstractBundle {
    public function loadExtension(
        array $config,
        ContainerConfigurator $containerConfigurator,
        ContainerBuilder $containerBuilder,
    ): void
    {
        $containerConfigurator->import('../config/services.yaml');
    }
}