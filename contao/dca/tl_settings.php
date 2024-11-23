<?php
/**
 * Easyrechtssicher integration for Contao Open Source CMS.
 *
 * @author    Dr. Manuel Lamotte-Schubert <mls@pronego.com>
 * @copyright 2024, PRONEGO - https://www.pronego.com
 * @license   LGPL-3.0-or-later
 */
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\Environment;
use Contao\Message;
use Symfony\Component\HttpClient\HttpClient;
use Pronego\EasyrechtssicherBundle\Service\ApiService;

// Fields definition
$GLOBALS['TL_DCA']['tl_settings']['fields']['license_domain'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['license_domain'],
    'inputType' => 'text',
    'eval'      => ['readonly' => true, 'tl_class' => 'w50', 'alwaysSave' => true],
    'load_callback' => [
        function () {
            return Environment::get('host'); // Read current installation domain
        }
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['apikey'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['apikey'],
    'inputType' => 'text',
    'eval'      => ['mandatory' => true, 'tl_class' => 'w50'],
    'save_callback' => [
        function ($apiKeyValue) {
            // Load current domain
            $apiService = new ApiService(HttpClient::create());
            $apiUrl = $apiService->generateApiUrl('imp', null, $apiKeyValue);

            $response = $apiService->callApi($apiUrl);


            if ( ! $response)
            {
                $message = sprintf($GLOBALS['TL_LANG']['ERR']['invalid_api_key'], Environment::get('host'));
                Message::addError($message);
                throw new \RuntimeException($message);
            }

            return $apiKeyValue;
        }
    ]
];

// Extend palette: Old way via concatenation
//$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{easyrechtssicher_legend},license_domain,apikey';

// New way: Add via PaletteManipulator
PaletteManipulator::create()
    ->addLegend('easyrechtssicher_legend', NULL, PaletteManipulator::POSITION_AFTER)
    ->addField(['license_domain', 'apikey'], 'easyrechtssicher_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings');