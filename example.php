<?php
/**
 * Example of use of the class Thread.
 */
include "Thread.php";

$app = new Thread($argv,$argc);

if($app->child !== false){
    // Code executed by the children

    // This is written to the threads/{$pid}.pid file
    echo 'Start at ', date("H:i:s"), chr(10);
    echo "I\'m child #{$app->child}\n";
    sleep(rand(0,10));

    // This is a variable created in the parent
    $app->XYU = $app->XYU + 1;

    echo 'Stop at ' . date("H:i:s") . chr(10);
    
    // This array is the result of the child. It can be readed later by the parent.
    $app->write (array("This is the child with the proccess id: {$app->child}","State"=>"I have ended", "Result"=>rand()));
}else{
    // Code executed by the parent

    // This variable can be changed by the childs
    $app->XYU = 0;
    
    echo "I'm parent. {$app->child}\n";
    $app->startThreads(10);

    $cur_c = 0;
    $las_c = 10;
    
    while( ($cur_c = $app->childs()) > 0){
        if($cur_c != $las_c){
            echo "There are {$cur_c} childs on fly\n";
            echo "XYU: {$app->XYU}\n";
        }
        $las_c = $cur_c;
        sleep(1);
    }
    
    for ($i = 1; $i <= 10; $i++){
      echo "Execution of the proccess {$i}\n";
		print_r ($app->read ($i)); echo "\n";
    }
}
echo "XYU: {$app->XYU}\n"; 
