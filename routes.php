<?php

$router->get('', 'PageController@index');
$router->get('delivery_fast', 'DeliveryController@fast');
$router->get('delivery_slow', 'DeliveryController@slow');
