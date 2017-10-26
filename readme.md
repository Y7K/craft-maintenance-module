# Y7K Craft CacheMonster Plugin

This plugin exposes two console commands:
```
php console cachemonster purgeCache
php console cachemonster crawlAndWarm
```

While the first one purges all Craft cache folders and the cached templates from the database, the latter also invokes the Cache Warmer Service.

