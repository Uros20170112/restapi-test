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
                $result = mysqli_query($dbl, $mydb->select())or die("Ubi se");
                print_r($result);
                $_POST = array();
            }
        }
    }
?>