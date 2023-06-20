<?php

function set_la($argv, &$la){

    for($i = 1; $i < count($argv); $i++)
        $la[] = intval($argv[$i]);
}

function sa(&$la, &$history){
    if($la[0] > $la[1]){
        $c = 0;

        $c = $la[0];
        $la[0] = $la[1];
        $la[1] = $c;

        $history .= "sa ";

        return true;
    }

    return false;
}

function sb(&$lb, &$history){
    if($lb[0] < $lb[1]){
        $c = 0;

        $c = $lb[0];
        $lb[0] = $lb[1];
        $lb[1] = $c;

        $history .= "sb ";

        return true;
    }

    return false;
}

function pa(&$la, &$lb, &$history){
    $c = 0;

    $c =  array_shift($lb);
    $laLength = array_unshift($la, $c);

    $history .= "pa ";
}

function pb(&$la, &$lb, &$history){
    $c = 0;

    $c =  array_shift($la);
    $lbLength = array_unshift($lb, $c);

    $history .= "pb ";
}

function ra(&$la, &$history){
    if($la[0] > $la[count($la) - 1]){
        $c = 0;
        $c = array_shift($la);
        $laLength = array_push($la, $c);

        $history .= "ra ";

        return true;
    }

    return false;
}

function rb(&$lb, &$history){
    if($lb[0] < $lb[count($lb) - 1] ){
        $c = 0;
        $c = array_shift($lb);
        $lbLength = array_push($lb, $c);

        $history .= "rb ";

        return true;
    }

    return false;
}

function rra(&$la, &$history){
    if($la[count($la) - 1] < $la[0]){
        $c = array_pop($la);
        $laLength = array_unshift($la, $c);

        $history .= "rra ";

        return true;
    }

    return false;
}

function rrb(&$lb, &$history){
    if($lb[count($lb) - 1] > $lb[0]){
        $c = array_pop($lb);
        $laLength = array_unshift($lb, $c);

        $history .= "rrb ";

        return true;
    }

    return false;
}

function is_sorted($la):bool{
    for($i = 0; $i < count($la) - 1; $i++){
        if($la[$i] > $la[$i + 1])
            return false;
    }

    return true;
}

function my_sort(&$la, &$lb, &$history){
    do{
        sort_la($la, $lb, $history);
        sort_lb($la, $lb, $history);
    }while(!(count($lb) === 0 && is_sorted($la)));

    history($history);
}

function sort_la(&$la, &$lb, &$history){
    while(!is_sorted($la)){
        $test1 = ra($la, $history);
        $test2 = sa($la, $history);
        $test3 = rra($la, $history);
        sa($la, $history);

        if(!$test1 && !$test2 && !$test3)
            pb($la, $lb, $history);
    }
}

function sort_lb(&$la, &$lb, &$history){
    while(count($lb) > 1 || !is_sorted($lb)){
        $test1 = rb($lb, $history);
        $test2 = sb($lb, $history);
        $test3 = rrb($lb, $history);

        if(!$test1 && !$test2 && !$test3)
            pa($la, $lb, $history);
    }

    if(count($lb) === 1)
        pa($la, $lb, $history);
    else{
        for($i = 0; $i < count($lb) - 1; $i++)
            pa($la, $lb, $history);
    }
}

function history(&$history){
    str_replace("sa sb", "sc", $history);
    str_replace("sb sa", "sc", $history);
    str_replace("ra rb", "rr", $history);
    str_replace("rb ra", "rr", $history);
    str_replace("rra rrb", "rrr", $history);
    str_replace("rrb rra", "rrr", $history);

    $history = trim($history);
    echo $history."\n";
}

?>