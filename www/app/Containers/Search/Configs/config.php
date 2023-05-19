<?php

return [
    'name' => 'Search',
    'hosts' => explode(',', (string) env('ELASTICSEARCH_HOSTS')),
];
