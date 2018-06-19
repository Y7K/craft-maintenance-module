<?php
/**
 * Maintenance module for Craft CMS 3.x
 *
 * All the tools needed to keep the app running smoothly.
 *
 * @link      y7k.com
 * @copyright Copyright (c) 2018 Y7K
 */

namespace Y7K\MaintenanceModule\console\controllers;

use Y7K\MaintenanceModule\MaintenanceModule;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Cachewarmer Command
 *
 * The first line of this class docblock is displayed as the description
 * of the Console Command in ./craft help
 *
 * Craft can be invoked via commandline console by using the `./craft` command
 * from the project root.
 *
 * Console Commands are just controllers that are invoked to handle console
 * actions. The segment routing is module-name/controller-name/action-name
 *
 * The actionIndex() method is what is executed if no sub-commands are supplied, e.g.:
 *
 * php craft maintenance-module/cachewarmer

 *
 * @author    Y7K
 * @package   MaintenanceModule
 * @since     1.0.0
 */
class CachewarmerController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Delete all template caches and make a call to the Cache Warmer
     */
    public function actionPurgeAndWarm()
    {
        $this
            // ->abortIfSystemIsOff()
            ->purgeRuntimeFolders()
            ->abortIfTemplateCachingIsDisabled()
            ->deleteAllTemplateCaches()
            ->abortIfOnLocalEnv()
            ->callCachewarmer();

        return Craft::$app->end();
    }

    /**
     * Update our url cache and force run the warming Task
     */
    public function actionPurgeCache()
    {
        $this
            // ->abortIfSystemIsOff()
            ->purgeRuntimeFolders()
            ->abortIfTemplateCachingIsDisabled()
            ->deleteAllTemplateCaches();

        return Craft::$app->end();
    }


    private function purgeRuntimeFolders()
    {
        echo 'Purging Runtime folders.' . "\r\n";
        MaintenanceModule::$instance->cachewarmer->clearRuntimeFolders();
        return $this;
    }

    private function deleteAllTemplateCaches()
    {
        echo 'Delete Template Cache.' . "\r\n";
        Craft::$app->templateCaches->deleteAllCaches();
        return $this;
    }

    private function callCachewarmer()
    {
        echo 'Call Cachewarmer.' . "\r\n";
        MaintenanceModule::$instance->cachewarmer->callCacheWarmer();
        return $this;
    }


    private function abortIfSystemIsOff()
    {
        // This seems to always return false. help.
        if (!Craft::$app->isSystemOn) {
            echo 'System is turned off. Abort.' . "\r\n";
            return Craft::$app->end();
        }
        return $this;
    }

    private function abortIfTemplateCachingIsDisabled()
    {
        if (!Craft::$app->config->general->enableTemplateCaching) {
            echo 'Template Caching is turned off. Abort.' . "\r\n";
            return Craft::$app->end();
        }
        return $this;
    }

    private function abortIfOnLocalEnv()
    {
        if (Craft::$app->config->general->appEnv === 'local') {
            echo 'We are on local environment. Abort.' . "\r\n";
            return Craft::$app->end();
        }
        return $this;
    }

}
