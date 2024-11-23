<?php
/**
 * Easyrechtssicher integration for Contao Open Source CMS.
 *
 * @author    Dr. Manuel Lamotte-Schubert <mls@pronego.com>
 * @copyright 2024, PRONEGO - https://www.pronego.com
 * @license   LGPL-3.0-or-later
 */
use Contao\CoreBundle\DataContainer\PaletteManipulator;

// Define field
$GLOBALS['TL_DCA']['tl_module']['fields']['siteType'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['siteType'], // optional since 4.9
    'inputType' => 'radio',
    'options'   => ['dse', 'imp', 'wbl'], // keys only
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['siteType_options'], // ref for translations
    'eval'      => ['mandatory' => true, 'tl_class' => 'w50'],
    'sql'       => "varchar(3) NOT NULL default ''"
];

// Extend palette and add fields
PaletteManipulator::create()
    ->addField('headline', 'title_legend', PaletteManipulator::POSITION_APPEND)
    ->addLegend('config_legend', 'default')
    ->addField('siteType', 'config_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_module');