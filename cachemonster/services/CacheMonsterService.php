<?php

namespace Craft;


/**
 * CacheMonster
 */
class CacheMonsterService extends BaseApplicationComponent
{

    /*
     * Delete the craft cache folders
     */
    public function clearRuntimeFolders()
    {
        foreach (['runtime/cache', 'runtime/compiled_templates', 'runtime/state'] as $folder) {
            echo 'Deleting storage folder: ' . $folder . "\r\n";
            exec('rm -rf '. CRAFT_STORAGE_PATH . $folder);
        }
    }

    /*
     * Call the cache warmer 📞
     */
    public function callCacheWarmer()
    {
        echo 'Initialize the Cache warmer... ' . "\r\n";
        $domain = rtrim(craft()->getSiteUrl(), '/');
        $url = 'https://maintenance.y7k.tools/api/warm-cache';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "domain={$domain}");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($curl);
    }

}
