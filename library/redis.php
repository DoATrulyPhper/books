<?php
$redisConf = config('databases.redis');
$redis = new Redis();
$redis->connect($redisConf['host'], $redisConf['port']);