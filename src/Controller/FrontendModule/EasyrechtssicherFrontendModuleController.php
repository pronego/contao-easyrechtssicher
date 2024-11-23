<?php
/**
 * Easyrechtssicher integration for Contao Open Source CMS.
 *
 * @author    Dr. Manuel Lamotte-Schubert <mls@pronego.com>
 * @copyright 2024, PRONEGO - https://www.pronego.com
 * @license   LGPL-3.0-or-later
 */
namespace Pronego\EasyrechtssicherBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\ServiceAnnotation\FrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Pronego\EasyrechtssicherBundle\Service\ApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Registration of the EasyRechtssicher frontend module via Annotation (since Contao 4.8).
 *
 * @FrontendModule("easyrechtssicher",
 *   category="miscellaneous",
 *   template="mod_easyrechtssicher",
 * )
 */
class EasyrechtssicherFrontendModuleController extends AbstractFrontendModuleController
{
    /** @var ApiService Service to connect to the EasyRechtssicher API. */
    private ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Handles displaying the HTML fragment returned by the API.
     *
     * @required
     */
    public function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $apiUrl = $this->apiService->generateApiUrl(
            $model->siteType,
            $request->getLocale(),
        );

        $template->output = $this->apiService->callApi($apiUrl);
        return $template->getResponse();
    }
}