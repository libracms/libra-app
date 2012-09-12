<?php
//define('ZF2_PATH', getenv('HOME') . '/workspace/zf2/library');

return array(
    'modules' => array(
        'LibraApp',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            'LibraApp'          => './vendor/libra/libra-app',
        ),
    ),
);
