<?php
/*
Plugin Name: iDEAL Mollie betalen doneren
Description: WordPress plugin om te betalen met iDEAL via Mollie
Version: v1.2
Author: <a href="mailto:marcel.verhaar@fikira.nl">Marcel Verhaar</a>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
# ---------------------------------------------------------------------------------------------------------------
/* 
Notepad for copy/paste and temporary things:

*/
# ---------------------------------------------------------------------------------------------------------------
# Configuration & Global variables
#
global $fip_permaLink;
global $fip_partnerid;
global $fip_bedrag;
global $fip_referentie;
global $errors;
$fip_permaLink =  "http://" . $_SERVER['SERVER_NAME']  . $_SERVER['REQUEST_URI'];


# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function requires_wordpress_version() {
	global $wp_version;
	$plugin = plugin_basename( __FILE__ );
	$plugin_data = get_plugin_data( __FILE__, false );

	if ( version_compare($wp_version, "3.5", "<" ) ) {
		if( is_plugin_active($plugin) ) {
			deactivate_plugins( $plugin );
			wp_die( "'".$plugin_data['Name']."' werkt met WordPress versie 3.5 en hoger!<br>Upgrade WordPress en activeer de plugin opnieuw.<br /><br />Terug naar <a href='".admin_url()."'>Admin pagina</a>." );
		}
	}
}
add_action( 'admin_init', 'requires_wordpress_version' );

# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function fip_plugin_activate() {
if( !get_option( 'fip_partnerid' ) ) {
update_option( 'fip_partnerid', "1234567890");
} 	
if( !get_option( 'fip_betaald_text' ) ) {
update_option( 'fip_betaald_text', "Bedankt voor de betaling. Het bedrag van EUR _BEDRAG_ is overgemaakt.");
}
if( !get_option( 'fip_geannuleerd_text' ) ) {
update_option( 'fip_geannuleerd_text',"De betaling is geannuleerd. Probeer het opnieuw.");
}
if( !get_option( 'fip_onbekend_text' ) ) {
update_option( 'fip_onbekend_text', "De betaalstatus kan niet worden opgevraagd. Controleer uw bankafschrift.");
}
if( !get_option( 'fip_betaalknop_text' ) ) {
update_option( 'fip_betaalknop_text', "Betalen");
}
}
register_activation_hook( __FILE__, 'fip_plugin_activate' );
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function fip_register_shortcodes(){
add_shortcode('IDEAL', 'fip_iDealPaymentMain');
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function fip_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=ideal_settings">Instellingen</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'fip_plugin_settings_link' );
add_filter('widget_text', 'do_shortcode', 11);
add_action( 'init', 'fip_register_shortcodes');




# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function myshortcode_handler()
{ 
static $first_call = TRUE;
    if ( ! $first_call )
    {
		echo "<b>Fout, De iDEAL betaal plugin is ergens anders al actief op de pagina.</b>";
		return true;
    }
    $first_call = FALSE;
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
add_action('admin_menu', 'ideal_plugin_settings');
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function ideal_plugin_settings() {
 add_menu_page('Mollie iDEAL donatie plugin instellingen', 'iDEAL plugin', 'administrator', 'ideal_settings', 'ideal_display_settings',plugins_url( 'ideal-mollie-betalen-doneren/icon.png' ));
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function ideal_display_settings() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

 

   $fip_partnerid = (get_option('fip_partnerid') != '') ? get_option('fip_partnerid') : '0';
   $fip_betaald_text = (get_option('fip_betaald_text') != '') ? get_option('fip_betaald_text') : 'Bedankt voor de betaling. Het bedrag van EUR _BEDRAG_ is overgemaakt.';
   $fip_geannuleerd_text = (get_option('fip_geannuleerd_text') != '') ? get_option('fip_geannuleerd_text') : 'De betaling is geannuleerd. Probeer het opnieuw.';
   $fip_onbekend_text = (get_option('fip_onbekend_text') != '') ? get_option('fip_onbekend_text') : 'De betaalstatus kan niet worden opgevraagd. Controleer uw bankafschrift.'; 
   $fip_testBank = (get_option('fip_testBank') != '') ? get_option('fip_testBank') : '0'; 
   $fip_betaalknop_text = (get_option('fip_betaalknop_text') != '') ? get_option('fip_betaalknop_text') : 'Betalen'; 
//$fip_testBank="0";




 
$html = '</pre>
<div class="wrap"><form action="options.php" method="post" name="options">
<h2>iDEAL Mollie betalen doneren instellingen</h2>
' . wp_nonce_field('update-options') . '
<table class="form-table" cellpadding="10">
<tbody>
<tr>
<td align="left" valign="top" style="width: 150px;"><label> Mollie PartnerID:</label></td>
<td align="left"><input type="text" name="fip_partnerid" value="' . $fip_partnerid . '" /><br><p class="description">Vul hier uw Mollie partnerid code in.</p></td>
</tr>

<tr>
<td  align="left" valign="top"><label> Betaald tekst:</label></td>
<td><textarea name="fip_betaald_text" cols="50" rows="2">'. $fip_betaald_text .'</textarea><br><p class="description">Vul hier in wat de plugin moet laten zien als de betaling succesvol is afgerond.<br>Gebruik <b>_BEDRAG_</b> om het bedrag te laten zien.(html is toegestaan)</p></td></td>
</tr>

<tr>
<td  align="left" valign="top"><label> Annulerings tekst:</label></td>
<td><textarea name="fip_geannuleerd_text" cols="50" rows="2">'. $fip_geannuleerd_text .'</textarea><br><p class="description">Vul hier in wat de plugin moet laten zien als de betaling geannuleerd is.(html is toegestaan)</p></td></td>
</tr>

<tr>
<td  align="left" valign="top"><label> Status onbekend tekst:</label></td>
<td><textarea name="fip_onbekend_text" cols="50" rows="2">'. $fip_onbekend_text .'</textarea><br><p class="description">Vul hier in wat de plugin moet laten zien als de betalingsstatus niet gecontroleerd kan worden. (html is toegestaan)</p></td></td>
</tr>

<tr>
<td align="left" valign="top" style="width: 150px;"><label> Betaalknop tekst:</label></td>
<td align="left"><input type="text" name="fip_betaalknop_text" value="' . $fip_betaalknop_text . '" /><br><p class="description">De tekst die u hier invult wordt weergegeven op de betaalknop.</p></td>
</tr>

<tr>
<td  align="left" valign="top"><label> Testmodus:</label></td>
<td><input type="checkbox" name="fip_testBank" value="1"';
echo $html;
checked( '1', get_option( 'fip_testBank' ) ); 
$html='
/><br><p class="description">Voegt een testbank toe aan de bankenlijst om te testen (Testmode moet ook bij Mollie geactiveerd zijn)</p></td></td>
</tr>


</tbody>
</table>
 <input type="hidden" name="action" value="update" />

 <input type="hidden" name="page_options" value="fip_testBank,fip_onbekend_text,fip_geannuleerd_text,fip_partnerid,fip_betaald_text,fip_betaalknop_text" />
<br>
 <input type="submit" name="Submit" value="Instellingen opslaan" class="button-primary"/></form></div>
<pre>
';

echo $html;


	
if( isset($_GET['settings-updated']) ) { ?>
<div id="message" class="updated">
<p><strong><?php _e('Settings saved.') ?></strong></p>
</div>
<?php } 

$help_01 = plugins_url( 'help_01.jpg', __FILE__ );
$help_02 = plugins_url( 'help_02.jpg', __FILE__ );
$help_03 = plugins_url( 'help_03.jpg', __FILE__ );
$help_04 = plugins_url( 'help_04.jpg', __FILE__ );

echo <<<EOF
<p>
<b>Help</b>
----
Met deze plugin kunt u klanten makkelijk laten betalen met iDEAL.
Om gebruik te kunnen maken van dit betaalsysteem heeft u een Mollie account nodig.
Als u geen Mollie account heeft dan kunt u deze openen op de website van <a href="http://www.mollie.nl" target="nieuw">Mollie</a>.
Deze plugin haalt de meeste recente iDEAL banken lijst op voor iedere transactie, op deze manier zijn nieuw aangesloten
banken direct zichtbaar.

Om de plugin te activeren moet u de shortcode <b>[IDEAL]</b> gebruiken. Dit kan zowel op pagina's, posts en widgets.
Ook zijn er een drietal parameters die optioneel meegegeven kunnen worden in de shortcode.

1. <b>fip_partnerid="12345678"</b>
   Deze parameter is optioneel. Als deze parameter niet is meegegeven dan wordt de PartnerID code van de instellingen gebruikt.
   Wees er wel zeker van dat u deze heeft ingevuld bij de instellingen anders geeft de plugin een melding.
   
2. <b>fip_referentie="Dit is een referentie"</b>
   Deze parameter is optioneel. Als u deze parameter meegeeft dan kunnen uw klanten zelf geen referentie invullen omdat het 
   tekstveld dan niet zichtbaar is. Deze optie is uitermate geschikt voor donaties.
   
3. <b>fip_bedrag="100,00"</b>
   Deze parameter is optioneel. Als u deze parameter meegeeft dan kunnen uw klanten zelf geen bedrag invullen omdat het 
   tekstveld dan niet zichtbaar is. Deze optie is uitermate geschikt voor donaties. 

-
Enkele voorbeelden:

1. <b>[IDEAL]</b>
   Met deze optie worden er helemaal geen parameters meegegeven, met deze optie moet het 'Mollie PartnerID' ingevuld worden.
   De betaalmodule ziet er dan als volgt uit:
   <img src="$help_02"> 
   Hier kan de klant zelf een referentie en bedrag opgeven voor de iDEAL transactie.
   Als u meerdere Mollie PartnerID's heeft dan kun u het beste ook de partnerID code in the shortlink zetten:
   <b>[IDEAL fip_partnerid="023456878"]</b>
  
2. <b>[IDEAL fip_bedrag="19,79"]</b>
   Met deze optie wordt alleen het bedrag vermeld.
   De betaalmodule ziet er dan zo uit:
   <img src="$help_03"> 
   De klant kan hier zelf geen bedrag kiezen maar wel een referentie opgeven voor de iDEAL transactie.
   Als u meerdere Mollie PartnerID's heeft dan kun u het beste ook de partnerID code in the shortlink zetten:
   <b>[IDEAL fip_partnerid="023456878" fip_bedrag="19,79"]</b>

3. <b>[IDEAL fip_referentie="Donatie"]</b>
   Met deze optie wordt alleen de referentie vermeld.
   De betaalmodule ziet er dan zo uit:
   <img src="$help_04"> 
   De klant kan hier zelf geen referentie invoeren maar wel een bedrag opgeven voor de iDEAL transactie.
   Als u meerdere Mollie PartnerID's heeft dan kun u het beste ook de partnerID code in the shortlink zetten:
   <b>[IDEAL fip_partnerid="023456878" fip_referentie="Donatie"]</b>
  
4. <b>[IDEAL fip_partnerid="023456878" fip_referentie="Donatie" fip_bedrag="1,20"]</b>
   Met deze optie worden er alle parameters meegegeven, de klant kan dan alleen een bank selecteren.
   De betaalmodule ziet er dan zo uit:
   <img src="$help_01"> 
   Als u meerdere Mollie PartnerID's heeft dan kun u het beste ook de partnerID code in the shortlink zetten:
   <b>[IDEAL fip_partnerid="023456878" fip_referentie="Donatie" fip_bedrag="1,20"]</b>
-
Indien de plugin meerdere keren is toegevoegd zal alleen de eerstgeladen zichtbaar zijn, dit i.v.m. form data.
  
Tip:
Als u een afbeelding wilt laten zien als een betaling succesvol is afgerond kunt u html gebruiken:
<b>&lt;img src=&quot;locatieAfbeelding&quot;&gt;</b>
</p>
EOF;
	
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function fip_iDealPaymentMain($fip_parameters)
{
global $fip_partnerid;
global $fip_bedrag;
global $fip_referentie;
global $errors;

ob_start(); 
echo '<div style="display:none">IDEAL_MOLLIE_BETALEN_DONEREN_AQZSUAWWMX</div>';
echo "<p>";
if (myshortcode_handler()){goto eind;}
//----------
extract(shortcode_atts(array(
'fip_partnerid' => "",
'fip_bedrag' => "",
'fip_referentie' => "",
), $fip_parameters));
//----------
if (isset($_GET['transaction_id'])) 
{    
getBetaalStatus();
}
else if (isset($_POST['actie'])) 
{  
$fip_bedrag = $_POST['fip_bedrag'];
$fip_referentie = $_POST['fip_referentie'];
$fip_partnerid= $_POST['fip_partnerid'];

$errors ="";
$fip_bedrag = str_replace(",", ".", $fip_bedrag);

if (empty($fip_referentie)){ $errors =$errors ."* Geef uw referentie op<br>"; $fip_referentie=""; }
if (empty($fip_bedrag) || !isValuta($fip_bedrag)){ $errors =$errors . "* Vul een correct bedrag in<br>";$fip_bedrag=""; }


if ($fip_bedrag != "") { 
$fip_bedrag = fixBedrag($fip_bedrag);
if ($fip_bedrag < 120 || $fip_bedrag > 5000000) { $errors =$errors . "* Bedrag moet hoger zijn dan 1,20 en lager dan 50000,00<br>";$fip_bedrag="";  }
}

if (!empty($errors))  {generateForm($fip_referentie,$fip_bedrag,$fip_partnerid,$errors);  }
else {

Request_Mollie_Payment_Link($fip_bedrag,$fip_referentie,$fip_partnerid);
}
}
else {
if (!empty($fip_partnerid)){ generateForm($fip_referentie,$fip_bedrag,$fip_partnerid,$errors);} else 
{ 
$fip_partnerid = get_option('fip_partnerid');
generateForm($fip_referentie,$fip_bedrag,$fip_partnerid,$errors);
//echo "FOUT: partnerid niet meegegeven!<br>Voorbeeld: [ IDEAL partnerid=\"234533\" ]";
}
//
}
eind:
echo "</p>";
$fip_output_string=ob_get_contents();
ob_end_clean();
return $fip_output_string;
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function fip_checkShortcodeParameters($fip_parameters)
{
extract(shortcode_atts(array(
'fip_partnerid' => "",
'fip_bedrag' => "",
'fip_referentie' => "",
), $fip_parameters));
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function generateForm($fip_referentie,$fip_bedrag,$fip_partnerid,$errors)
{

$fip_betaalknop_text = get_option('fip_betaalknop_text');
if (!empty($errors)){echo "$errors<br>";}
echo <<<EOF
<form name="form1" method="post" action="{$fip_permaLink}">  
EOF;
fetchBanken();
if (empty($fip_referentie)) { echo "<br>Referentie:<br><input name=\"fip_referentie\" type=\"text\" value=\"$fip_referentie\" size=\"40\" maxlength=\"32\"><br>"; } else { echo "<input name=\"fip_referentie\" type=\"hidden\" value=\"$fip_referentie\">"; }
if (empty($fip_bedrag)) { echo "<br>Bedrag:<br><input name=\"fip_bedrag\" type=\"text\" value=\"$fip_bedrag\" size=\"40\"><br>"; } else { echo "<input name=\"fip_bedrag\" type=\"hidden\" value=\"$fip_bedrag\">"; }

echo <<<EOF
<input name="fip_partnerid" type="hidden" value="$fip_partnerid">
<input name="actie" type="hidden" value="betaal">
<br>
<input type="submit" value="$fip_betaalknop_text"> 
</form> 
EOF;
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function FetchBanken()
{
global $fip_testBank;
 
$mollie_bank_request_url = "https://secure.mollie.nl/xml/ideal?a=banklist";
$mollie_bank_response_url = file_get_contents($mollie_bank_request_url);
$xml_data = simplexml_load_string($mollie_bank_response_url);

 
$array = (array)$xml_data;

 if (get_option('fip_testBank')=="1"){ echo "<b>Let op! Testmodus actief.</b><br>";  }
 echo "Bank:<br>";
 echo "<select name=\"bank_id\">";
 foreach ($xml_data->bank as $bank) 
 {
 echo "<option value=\"$bank->bank_id\">$bank->bank_name</option>";
 }
 if (get_option('fip_testBank')=="1")
 { 
 echo "<option value=\"9999\" selected>TestBank (Debug)</option>";	 
 } 
 echo "</select><br>";
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function Request_Mollie_Payment_Link($fip_bedrag,$fip_referentie,$fip_partnerid)
{
global $fip_permaLink;
$bank_id = $_POST["bank_id"];
$fip_referentie = preg_replace('/[^ \w]+/', '+', $fip_referentie);
$fip_referentie = str_replace(" ", "+", $fip_referentie);
$fip_partnerid= preg_replace("/[^0-9]/","",$fip_partnerid);
$dummy =plugins_url( 'dummy.php', __FILE__ );
$mollie_generated_link = 'https://secure.mollie.nl/xml/ideal?a=fetch&partnerid=' . $fip_partnerid . '&description=' . $fip_referentie . '&reporturl=' . $dummy . '?mode=report&returnurl=' . $fip_permaLink . '&amount='. $fip_bedrag .'&bank_id='. $bank_id;


$xml_data = simplexml_load_file($mollie_generated_link);
if (!empty($xml_data->item->errorcode))
{
echo "Er gaat iets fout:<br>".$xml_data->item->message;
} else {
$payment_link = $xml_data->order->URL;
redirect($payment_link);
}
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function redirect($payment_link)
{
# Redirect naar de gegenereerde Mollie URL, we gebruiken hiervoor een JS redirect. Omdat WordPress al headers heeft gestuurd
# voor dat dit script aangeroepen werd kunnen we: 'header("Location: $payment_link");' niet gebruiken :(
echo "Momentje... U wordt omgeleid naar de iDEAL betaalpagina";
echo <<<EOF
   <script type="text/javascript">
   <!--
      window.location="$payment_link";
   //-->
   </script>
EOF;
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function isValuta($c)
{

$c = str_replace(",", ".", $c);

# Controle of het opgegeven bedrag daadwerkelijk valuta is
# xxxxxxxxx.xx
# We accepteren tot 2 decimalen achter de comma.
return preg_match("/^-?[0-9]+(?:\.[0-9]{2})?$/", $c);
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function fixBedrag($c)
{
$punt   = '.';
$pos = strpos($c, $punt);
if ($pos === false) 
{
// Er is geen . gevonden dus adden we eerst een . met 2 decimalen
$c .=".00";
}
$c = str_replace(".", "", $c);
return($c);
}
# -------------------------------------------------------------------------------------------------------------------------------------------------------------
function getBetaalStatus()
{
global $fip_permaLink;
$transaction_id = $_GET['transaction_id'];
$transaction_status_request_url = "https://secure.mollie.nl/xml/ideal?a=check&partnerid=1173991&transaction_id=" . $transaction_id . "&testmode=false";
$transaction_status_response_url = file_get_contents($transaction_status_request_url);
$xml_data = simplexml_load_string($transaction_status_response_url);


if ($xml_data->order->payed == "true" && $xml_data->order->status == "Success") 
{ 

//setlocale(LC_MONETARY,"nl_NL");
$bedrag = floatval($xml_data->order->amount)/100;
$bedrag = money_format("%.2n", $bedrag);

$tmp = get_option('fip_betaald_text'); 
$tmp = str_replace("_BEDRAG_", "$bedrag", $tmp);

echo $tmp;

} 
else if ($xml_data->order->payed == "false" && $xml_data->order->status == "Cancelled")
{
// Geannuleerd
$tmp = get_option('fip_geannuleerd_text'); 
echo $tmp;
doeRefreshLink();
 
}
else if ($xml_data->order->payed == "false" && $xml_data->order->status == "Expired")
{
// Verlopen
echo <<<EOF
De betaling is verlopen, probeer het opnieuw.
EOF;
doeRefreshLink();
}
else if ($xml_data->order->payed == "false" && $xml_data->order->status == "Failure")
{
// Fout
echo <<<EOF
Er is iets misgegaan met de betaling, probeer het opnieuw.
EOF;
doeRefreshLink();
}
else if ($xml_data->order->payed == "false" && $xml_data->order->status == "CheckedBefore")
{
// Status was al opgevraagd
echo <<<EOF
De betaalstatus is al een keer opgevraagd. Wegens veiligheidsredenen kunnen we dit niet nogmaals opvragen, controleer a.u.b. uw bankafschrift.
EOF;
}
else if ($xml_data->order->payed == "false" && $xml_data->order->status == "Open")
{
// Status van de order is onbekend
$tmp = get_option('fip_onbekend_text'); 
echo $tmp;
doeRefreshLink();
}
}


function doeRefreshLink()
{
global $fip_permaLink;
echo <<<EOF
<br><a hef="#" onclick="javascript:(window.location='
EOF;
$url = explode("?", $fip_permaLink); 
echo $url[0];
echo <<<EOF
');">Opnieuw</a>
EOF;
}





?>