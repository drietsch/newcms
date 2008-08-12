<?php

$i = 0;

$validationService[] = new validationService(
                            $i++,
                            'default',
                            'css',
                            $l_validation['service_css_upload'],
                            'jigsaw.w3.org',
                            '/css-validator/validator',
                            'post',
                            'file',
                            'fileupload',
                            'text/css',
                            'usermedium=all&submit=check',
                            '.css',
                            1);


$validationService[] = new validationService(
                            $i++,
                            'default',
                            'css',
                            $l_validation['service_css_url'],
                            'jigsaw.w3.org',
                            '/css-validator/validator',
                            'get',
                            'uri',
                            'url',
                            'text/css',
                            'usermedium=all',
                            '.css',
                            1);
?>