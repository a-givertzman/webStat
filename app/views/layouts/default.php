<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">
        <?=$this->getMeta();?>
    </head>
    <body>
        <h1>Layout DEFAULT</h1>
        
        <?=$content;?>
        
        <?php
            $logs = RB::getDatabaseAdapter()
                ->getDatabase()
                ->getLogger();

        // debug( $logs->grep( 'SELECT' ) );
        ?>
        
    </body>
</html>
