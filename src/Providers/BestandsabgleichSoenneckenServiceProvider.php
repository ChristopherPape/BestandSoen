<?php

namespace BestandSoen\Providers;


use Plenty\Plugin\ServiceProvider;

class BestandsabgleichSoenneckenServiceProvider extends ServiceProvider{


    public function register(){

        $this->getApplication()->register(BestandsabgleichSoenneckenServiceProvider::class);

    }
}
?>