<?php

return [
    'cdn_url' => (env('APP_ENV', 'local') === 'production') ? '//d16gqslxckkrrx.cloudfront.net' : '//faithpromise.192.168.10.10.xip.io'
];