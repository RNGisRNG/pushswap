<?php

require_once('function.php');

function pushswap($argv){
    $history = "";
    $la = [];
    $lb = [];

    set_la($argv, $la);
    my_sort($la, $lb, $history);
}

pushswap($argv);

?>