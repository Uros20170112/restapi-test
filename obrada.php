<?php
    include "Database.php";
    $mydb = new Database('rest');
    if(isset($_POST["posalji"]) && $_POST["posalji"]="Posalji zahtev"){
        if($_POST["naslov_novosti"]!=null && $_POST["tekst_novosti"]!=null && $_POST["kategorija_odabir"]!=null){
            $niz = ["naslov"=> "'".$_POST["naslov_novosti"]."'", "tekst"=>"'".$_POST["tekst_novosti"]."'", "datumvreme"=>"NOW()", "kategorija_id"=>$_POST["kategorija_odabir"]];
            $mydb->insert("novosti", "naslov, tekst, datumvreme, kategorija_id", $niz);
            $_POST = array();
        }
        elseif($_POST["kategorija_naziv"]!=null) {
            $niz = ["kategorija"=>"'".$_POST["kategorija_naziv"]."'"];
            $mydb->insert("kategorije", "kategorija", $niz);
            $_POST = array();
        }
        elseif($_POST["odabir_tabele"]!=null && $_POST["id_novosti"]!=null && $_POST["naslov_novosti_put"]!=null && $_POST["tekst_novosti_put"]!=null && $_POST["kategorija_odabir_put"]!= null){
            echo 'cao3';   
            $niz = [0=> "'".$_POST["naslov_novosti_put"]."'", 1=>"'".$_POST["tekst_novosti_put"]."'", 2=>"NOW()", 3=>$_POST["kategorija_odabir_put"]];
            $table = $_POST["odabir_tabele"];
            $id = $_POST["id_novosti"];
            $keys = array(0=>'naslov', 1=>'tekst', 2=>'datumvreme', 3=>'kategorija_id');
            $mydb->update($table, $id, $keys, $niz);
            $_POST = array();
         }
        elseif($_POST["odabir_tabele"]!=null && $_POST["id_kategorije"]!=null && $_POST["kategorija_naziv_put"]!=null ) {
            $niz = [0=>"'".$_POST["kategorija_naziv_put"]."'"];
            $table = $_POST["odabir_tabele"];
            $id = $_POST["id_kategorije"];
            $keys = array(0=>'kategorija');
            $mydb->update($table, $id, $keys, $niz);
        }
        elseif($_POST["brisanje"]!=null && $_POST["odabir_tabele"]!=null){
            $tabela = $_POST["odabir_tabele"];
            $id = "id";
            $id_val = $_POST["brisanje"];
            $mydb->delete($tabela,$id,$id_val);
            $_POST = array();
        }
        elseif($_POST["odabir_tabele"]!=null && $_POST["http_zahtev"]!=null){
            if($_POST["http_zahtev"]=='get') {
                $list = $mydb->select();
                $mydb->select();
                while($red = $mydb->getResult()->fetch_object()){
                   // echo $red;
                   echo "{ ".$red->id;
                   echo '<br>';
                   echo $red->naslov;
                   echo '<br>';
                   echo $red->tekst;
                   echo '<br>';
                   echo $red->datumvreme;
                   echo '<br>';
                   echo $red->kategorija_id;
                   echo ' }<br>';
                   echo '<br>';
                   echo '<br>';
                    //print_r($red);
                }
        //         $record=mysqli_query($dblink,$q);
        // $list = array();
        // while($row=mysqli_fetch_assoc($record)){
        // //fill array how to fill array that will look like bellow from database???
        //     $list[] = $row;
        //    // print_r($row);
        // }
        // return $list;
        //         for($i=0; $i<sizeof($list); $i++){
        //           //  print_r($list[$i]);
        //             echo "{".$list[$i]['id'];
        //             echo '<br>';
        //             echo $list[$i]['naslov'];
        //             echo '<br>';
        //             echo $list[$i]['tekst'];
        //             echo '<br>';
        //             echo $list[$i]['datumvreme'];
        //             echo '<br>';
        //             echo $list[$i]['kategorija_id'];
        //             echo '<br>';
        //             echo $list[$i]['kategorija'];
        //             echo '}<br>';
        //             echo '<br>';
        //             echo '<br>';
        //         }
            }
        }
    }
?>