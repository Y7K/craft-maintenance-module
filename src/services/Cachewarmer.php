<?php
/**
 * Maintenance module for Craft CMS 3.x
 *
 * All the tools needed to keep the app running smoothly.
 *
 * @link      y7k.com
 * @copyright Copyright (c) 2018 Y7K
 */

namespace y7k\maintenancemodule\services;

use craft\helpers\FileHelper;
use craft\helpers\UrlHelper;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use y7k\maintenancemodule\MaintenanceModule;

use Craft;
use craft\base\Component;

/**
 * Cachewarmer Service
 *
 * All of your module’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other modules can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Y7K
 * @package   MaintenanceModule
 * @since     1.0.0
 */
class Cachewarmer extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * Delete the craft cache folders
     *
     * MaintenanceModule::$instance->cachewarmer->clearRuntimeFolders()
     */
    public function clearRuntimeFolders()
    {
        $pathService = Craft::$app->getPath();

        $dirs = [
            $pathService->getCompiledTemplatesPath(false),
            $pathService->getSessionPath(false),
            $pathService->getCachePath(false),
            $pathService->getCompiledClassesPath(false),
        ];
        foreach ($dirs as $dir) {
            try {
                FileHelper::clearDirectory($dir);
            } catch (\Exception $e) {
                // the directory doesn't exist
            }
        }
    }

    /*
     * Call the cache warmer 📞
     */
    public function callCacheWarmer($sitemap = 'sitemap.xml')
    {
        $domain = UrlHelper::siteHost();
        $url = 'https://maintenance.y7k.tools/api/warm-cache';

        $client = new Client();

        $client->post($url, [
            RequestOptions::JSON => compact('domain', 'sitemap')
        ]);
    }
}
