<?php

require_once(__DIR__ . '/Classes/Vizar.php');
require_once(__DIR__ . '/Routes/routeRegistrar.php');
header("Cache-Control: no-store, no-cache, must-revalidate");
error_reporting(0);

?>

<style>

.row{min-width: 1024px !important}

</style>

<?php

session_start();
function vizar()
{
   $html = '<div class="row">'; 
   $html .= '<span class="col-sm-12">';
   $html .= '<h3>ELŐZETES HAVI LAKOSSÁGI DÍJKALKULÁTOR</h3><br>';
   $html .= '</span>';
   $html .= '<span class="col-sm-6">';
   $html .= '<label for="telepules">Település kiválasztása</label><br>';
   $html .= '<select name="telepules" id="telepules"></select>';
   $html .= '</span>';
   $html .= '<span id="felhasz_container" class="col-sm-6" style="display: none;">';
   $html .= '<label for="felhasznalas">Felhasználás jellege</label><br>';
   $html .= '<select name="felhasznalas" id="felhasznalas"></select>';
   $html .= '</span>';
   $html .= '</div>';
   $html .= '<div class="row">';
   $html .= '<span class="col-sm-8"><br>';
   $html .= '<h3>Közműszolgáltatás</h3><br>';
   $html .= '<input type="checkbox" id="ivoviz" name="ivoviz" value="Ivóvíz alapdíj">';
   $html .= '<label for="ivoviz"> Ivóvíz szolgáltatás </label><br>';
   $html .= '<input type="checkbox" id="szennyviz" name="szennyviz" value="Szennyvíz alapdíj">';
   $html .= '<label for="szennyviz"> Szennyvízelvezetés és tisztítás </label><br>';
   $html .= '</span>';
   $html .= '</div>';
   $html .= '<div class="row">';
   $html .= '<span class="col-sm-8"><br>';
   $html .= '<h3>Fogyasztás</h3><br>';
   $html .= '<input type="number" min="0" id="fogyasztas" required name="fogyasztas">';
   $html .= '<label for="fogyasztas"> (m3) </label><br><br>';
   $html .= '<button type="button" id="calculate" class="btn btn-submit">Kiszámítás</button>';
   $html .= '</span>';
   $html .= '</div>';
   $html .= '<div id="calc-container" class="col-sm-12" style="display: none; border-color: blue; padding: 10px; border: solid; min-height:200px; min-width:1000px;">';
   $html .= '<p><b> 1 HAVI SZOLGÁLTATÁSI DÍJ JELENLEGI ÁRAINKON: </b></p>';
   $html .= '<div style="display: none;" id="calculated-ivo"></div><br>';
   $html .= '<div style="display: none;" id="calculated-szenny"></div>';
   $html .= '</div>';
   $html .= '<span id="hidden"></span>';  

 return $html; }  
 add_shortcode('vizar', 'vizar'); ?>

<?php
function wpb_hook_javascript()
{
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="<?php echo get_template_directory_uri();?>/vizar/includes/getTelepules.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/vizar/includes/getJelleg.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/vizar/includes/getResults.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<?php
}

add_action('wp_head', 'wpb_hook_javascript');

?>