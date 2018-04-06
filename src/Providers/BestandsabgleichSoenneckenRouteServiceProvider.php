<?php

namespace BestandSoen\Providers;


use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class BestandsabgleichSoenneckenRouteServiceProvider extends RouteServiceProvider{

    public function map(Router $router){

        $router->get('testsite','BestandSoen\Controllers\ContentController@tranferData');

    }
}
?>