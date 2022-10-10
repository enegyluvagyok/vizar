<?php

class Vizar
{

  public function getTelepules()
  {

    global $wpdb;

    $table = $wpdb->prefix . 'vizar';
    $results = $wpdb->get_results("SELECT DISTINCT telepules FROM $table");
    $html = '<option value="">Válasszon települést</option>';

    foreach ($results as $result) {
      $html .=  '<option value="' . $result->telepules . '">' . $result->telepules . '</option>';
    }

    echo $html;
  }

  public function getAgazat($telepules)
  {

    global $wpdb;
    $telepules = $_GET['telepules'];

    $table = $wpdb->prefix . 'vizar';
    $results = $wpdb->get_results("SELECT DISTINCT agazat FROM $table where telepules LIKE '$telepules';");
    $html = '';

    foreach ($results as $result) {
      $html .=  '<option value="' . $result->agazat . '">' . $result->agazat . '</option>';
    }

    echo $html;
  }

  public function getResults()
  {

    global $wpdb;
    $telepules = null;
    $felhasznalas = null;

    $vizteher = '';
    $ivoalap = '';
    $szennyvizalap = '';
    $vizszolg = '';
    $szennyvizszolg = '';
    $html = '';


    if (isset($_POST['telepules'])) {
      $telepules = $_POST['telepules'];
    }
    if (isset($_POST['felhasznalas'])) {
      $felhasznalas = $_POST['felhasznalas'];
    }

    $table = $wpdb->prefix . 'vizar';
    $results = $wpdb->get_results("SELECT * FROM $table where telepules LIKE '$telepules' AND agazat LIKE '$felhasznalas';");

    foreach ($results as $result) {
      if ($result->dijkategoria == 'Áthárított vízterhelési díj') {
        $vizteher = number_format(floatval($result->arak), 2);
      }
      if ($result->dijkategoria == 'Ivóvíz alapdíj') {
        if($result->atmero != null){
        $item = explode('-', $result->atmero);
        $ivoalap_arr[$item[0]] = floatval($result->arak);
        }else{
          $ivoalap_arr['0'] = floatval($result->arak);
        }
      }
      if ($result->dijkategoria == 'Szennyvíz alapdíj') {
        if($result->atmero != null){
        $item = explode('-', $result->atmero);
        $szennyvizalap_arr[$item[0]] = floatval($result->arak);
        }else{
          $szennyvizalap_arr['0'] = floatval($result->arak);
        }
      }
      if ($result->dijkategoria == 'Ivóvíz szolgáltatás') {
        $vizszolg = number_format(floatval($result->arak), 2);
      }
      if ($result->dijkategoria == 'Szennyvíz szolgáltatás') {
        $szennyvizszolg = number_format(floatval($result->arak), 2);
      }
    }

    if (isset($ivoalap_arr) && is_array($ivoalap_arr)) {
      $ivoalap = number_format(floatval($ivoalap_arr[min(array_keys($ivoalap_arr))]), 2);
    }
    if (isset($szennyvizalap_arr) && is_array($szennyvizalap_arr)) {
    $szennyvizalap = number_format(floatval($szennyvizalap_arr[min(array_keys($szennyvizalap_arr))]), 2);
    }

    $html .= '<input type="hidden" name="vizteher" id="vizteher" value="' . $vizteher . '">';
    $html .= '<input type="hidden" name="ivoalap" id="ivoalap" value="' . $ivoalap . '">';
    $html .= '<input type="hidden" name="vizszolg" id="vizszolg" value="' . $vizszolg . '">';
    $html .= '<input type="hidden" name="szennyvizalap" id="szennyvizalap" value="' . $szennyvizalap . '">';
    $html .= '<input type="hidden" name="szennyvizszolg" id="szennyvizszolg" value="' . $szennyvizszolg . '">';

    echo $html;
  }
}
