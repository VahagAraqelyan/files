<?php
Class Redis {

    public  function conf(){

        $client = new Predis\Client([
            'scheme'   => 'tcp',
            'host'     => 'localhost',
            'port'     => 6379,
            'database' => 1
        ]);

        return $client;
    }

}

?>