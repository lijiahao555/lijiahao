<?php

use Redis;

// */1 * * * * /phpstudy/server/php/bin/php /phpstudy/www/a.php

echo Redis::lpop('plan');