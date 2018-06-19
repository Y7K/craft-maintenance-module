<?php
/**
 * Maintenance module for Craft CMS 3.x
 *
 * All the tools needed to keep the app running smoothly.
 *
 * @link      y7k.com
 * @copyright Copyright (c) 2018 Y7K
 */

namespace Y7K\MaintenanceModule;

use Y7K\MaintenanceModule\services\Cachewarmer as CachewarmerService;

use Craft;
use craft\console\Application as ConsoleApplication;

use yii\base\Module;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Y7K
 * @package   MaintenanceModule
 * @since     1.0.0
 *
 * @property  CachewarmerService $cachewarmer
 */
class MaintenanceModule extends Module
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this module class so that it can be accessed via
     * MaintenanceModule::$instance
     *
     * @var MaintenanceModule
     */
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@Y7K/MaintenanceModule', $this->getBasePath());

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * Set our $instance static property to this class so that it can be accessed via
     * MaintenanceModule::$instance
     *
     * Called after the module class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$instance = $this;

        // Add in our console commands
        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = '\Y7K\MaintenanceModule\console\controllers';
        }
    }

    // Protected Methods
    // =========================================================================
}
