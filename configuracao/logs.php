<?php

        return array(
        'rootLogger' => array(
            'appenders' => array('default'),
        ),
        'appenders' => array(
            'default' => array(
                'class' => 'LoggerAppenderFile',
                'layout' => array(
                    'class' => 'LoggerLayoutSimple'
                ),
                'params' => array(
                	'file' => 'logs/' . date('Y/m/d') . '.log',
                	'append' => true
                )
            )
        )
    );

