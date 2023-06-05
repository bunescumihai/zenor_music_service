<?php
    //citire/scirere matrici
    $file = fopen('file2.txt', 'r');
    $s = fgets($file);
    $arr = explode(' ', $s);
    $n = (int) $arr[0];
    $m = (int) $arr[1];
    $matrix = array();

    for($i = 0; $i < $n; $i++){
        $row = array();
        $s = fgets($file);
        $arr = explode(' ', $s);
        for($j = 0; $j < $m; $j++){
            array_push($row, (int) $arr[$j]);
        }
        array_push($matrix, $row);
    }

    $file3 = fopen('file3.txt', 'w');
    for($i = 0; $i < $n; $i++){
        for($j = 0; $j < $m; $j++){
            fwrite($file3, ($matrix[$i][$j]*2).' ');
        }
        fwrite($file3, "\n");
    }
    fclose($file);
    fclose($file3);

    //extragere din bd
    $file = fopen('file1.txt', 'w');
    fwrite($file, '143');
    include 'php/connect_db.php';

    $sql = "Select `name` from music";
    $rs = $dbh->query($sql)->fetchAll();
    foreach ($rs as $item) {
        fwrite($file, $item['name']."\n");
    }
    fclose($file);


    //dir hierarchy
    $file = fopen('file.txt', 'w');

    function view_dr($dir, $niv = 0){
        global $file;
        $d = $dir;
        $dir = dir($dir);
        chdir($d);
        while($nom = $dir->read()){
            if($nom != '.' && $nom != '..'){
                echo '<pre>';

                for($i = 0; $i < $niv; $i++){
                    echo "\t";
                    fwrite($file, "\t");
                }

                fwrite($file, $nom." ".date('Y/m/d H:i:s', filectime($nom))."\t".date('Y/m/d H:i:s', filemtime($nom))."\t".date('Y/m/d H:i:s', fileatime($nom))."\n");
                echo $nom;
                echo '</pre>';
                if(is_dir($nom)){
                    view_dr($nom, $niv+1);
                }
            }
        }
        chdir('..');
    }

    view_dr('.');
    fclose($file);

//" ".filectime($nom)." ".filemtime($nom)." ".fileatime($nom).

?>
