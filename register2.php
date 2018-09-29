<?php
/*================================================================+\
|| # PHPRetro - An extendable virtual hotel site and management
|+==================================================================
|| # Copyright (C) 2009 Yifan Lu. All rights reserved.
|| # http://www.yifanlu.com
|| # Parts Copyright (C) 2009 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|| # All images, scripts, and layouts
|| # Copyright (C) 2009 Sulake Ltd. All rights reserved.
|+==================================================================
|| # PHPRetro is provided "as is" and comes without
|| # warrenty of any kind. PHPRetro is free software!
|| # License: GNU Public License 3.0
|| # http://opensource.org/licenses/gpl-license.php
\+================================================================*/

require_once('./includes/core.php');
require_once('./includes/csrf.class.php');

$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

$data = new register_sql;
$lang->addLocale("landing.register");

$page['name'] = $lang->loc['pagename.register'];
if(isset($_GET['registerCancel']) && $_GET['registerCancel'] == "true"){
session_unset();
header("Location: ".PATH."/"); exit;
}

if($session['username']){ header("Location: ".PATH."/"); exit; }


if( isset($_POST['register-username']) && $csrf->check_valid('post')){
$figure = $input->FilterText($_POST['register-look']);
$name = $input->FilterText($_POST['register-username']);
$password = $input->FilterText($_POST['register-password']);
$retypedpassword = $input->FilterText($_POST['register-password-repeat']);
$email = $input->FilterText($_POST['register-email']);
$accept_tos = $_POST['register-agb'];



$_SESSION['bean_avatarName'] = $_POST['register-username'];
$_SESSION['password'] = $_POST['register-password'];
$_SESSION['retypedPassword'] = $_POST['register-password-repeat'];
$_SESSION['bean_email'] = $_POST['register-email'];


$_SESSION['bean_termsOfServiceSelection'] = $_POST['register-agb'];
$_SESSION['bean_figure'] = $_POST['register-look'];

}elseif(isset($_SESSION['bean_avatarName'])){
$name = $input->FilterText($_SESSION['bean_avatarName']);
$password = $input->FilterText($_SESSION['password']);
$retypedpassword = $input->FilterText($_SESSION['retypedPassword']);
$email = $input->FilterText($_SESSION['bean_email']);
$accept_tos = $_SESSION['bean_termsOfServiceSelection'];
$figure = $input->FilterText($_SESSION['register-look']);


}

if(isset($_POST['register-username']) || isset($_SESSION['bean_avatarName'])){

// Start validating the stuff the user has submitted
$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $name);
$email_check = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $email);

// If this variable stays false, we're safe and can add the user. If not, it means that
// we've encountered errors and we can not proceed, so instead show the errors and do not
// add the user to the database.
$failure = false;
$lang->addLocale("register.errors");

	// Name validation
	if($serverdb->num_rows($serverdb->query("SELECT id,name,email FROM ".PREFIX."users WHERE name = '".$name."' LIMIT 1")) > 0){
		$error['name'] = $lang->loc['error.2'];
		$failure = true;
	} elseif($filter != $name){
		$error['name'] = $lang->loc['error.3'];
		$failure = true;
	} elseif(strlen($name) > 24){
		$error['name'] = $lang->loc['error.4'];
		$failure = true;
	} elseif(strlen($name) < 1){
		$error['name'] = $lang->loc['error.5'];
		$failure = true;
	}

	// MOD- Names validation
	$first = substr($name, 0, 4);
	if (strnatcasecmp($first,"MOD-") == false) {
		$error['name'] = $lang->loc['error.6'];
		$failure = true;
	}

	// Password validation
	if($password !== $retypedpassword){
		$error['password'] = $lang->loc['error.7'];
		$failure = true;
	} elseif(strlen($password) < 6){
		$error['password'] = $lang->loc['error.8'];
		$failure = true;
	/*} elseif(strlen($password) > 20){
		$error['password'] = "Please shorten your password to 20 characters or less!";
		$failure = true;*/
	}

	// E-Mail validation
	if(strlen($email) < 6){
		$error['mail'] = $lang->loc['error.9'];
		$failure = true;
	} elseif($email_check !== 1){
		$error['mail'] = $lang->loc['error.9'];
		$failure = true;
	} 
	

	
	// Finally, if everything's OK we add the user to the database, log him in, etc
	if($failure == false){
		$scredits = $settings->find("register_start_credits");
		$dob = "1-1-1900";
		$password = $input->HoloHash($password, $name);
		$data->insert1($name,$password,$dob,$figure,$scredits);
		$row = $serverdb->fetch_row($data->select3($name));
		$serverdb->query("INSERT INTO ".PREFIX."users (id,name,lastvisit,online,ipaddress_last,newsletter,email_verified,show_home,email_friendrequest,email_minimail,email,show_online) VALUES ('".$row[0]."','".$row[1]."','".time()."','".time()."','".$_SERVER[REMOTE_ADDR]."','".$newsletter."','0','1','1','1','".$email."','1')");
		if($scredits > 0){
			$db->query("INSERT INTO ".PREFIX."transactions (userid,time,amount,descr) VALUES ('".$row[0]."','".time()."','".$scredits."','Welcome to " . $sitename . "!')");
		}
		$db->query("INSERT INTO ".PREFIX."homes (ownerid,itemid,x,y,z,skin,location) VALUES ('".$row[0]."','101','482','86','3','defaultskin','0')");
		$db->query("INSERT INTO ".PREFIX."homes (ownerid,itemid,x,y,z,skin,location) VALUES ('".$row[0]."','107','485','352','6','defaultskin','0')");
		$db->query("INSERT INTO ".PREFIX."homes (ownerid,itemid,x,y,z,skin,location) VALUES ('".$row[0]."','105','70','290','9','defaultskin','0')");  
		if($settings->find("email_verify_enabled") == "1"){
		$hash = "";
		$length = 8;
		$possible = "0123456789qwertyuiopasdfghjkzxcvbnm";
		$i = 0;
		while ($i < $length) {
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($hash, $char)) {
		  $hash .= $char;
		  $i++;
		}
		}
		$hash = sha1($hash);
		$num = $key;
		$db->query("INSERT INTO ".PREFIX."verify (id,email,key_hash) VALUES ('".$row[0]."','".$email."','".$hash."')");
		$lang->addLocale("email.confirmationemail");
		if($settings->find("email_verify_reward") != "0"){ $reward_text = $lang->loc['email.reward']." ".$settings->find("email_verify_reward")." ".$lang->loc['credits']; }else{ $reward_text = ""; }
		$subject = $lang->loc['email.subject']." ".SHORTNAME;
		$to = $email;
		$html = 
		'<h1 style="font-size: 16px">'.$lang->loc['email.verify.1'].'</h1>

		<p>
		'.$reward_text.'
		'.$lang->loc['email.verify.2'].' <a href="'.PATH.'/email?key='.$hash.'">'.$lang->loc['email.verify.2.b'].'</a>
		</p>

		<p>
		'.$lang->loc['email.verify.3'].'
		</p>

		<blockquote>
		<p>
		<b>'.$lang->loc['email.verify.4'].'</b> '.$name.'<br>
		<b>'.$lang->loc['email.verify.5'].'</b> '.$dob.'
		</p>
		</blockquote>

		<p>
		'.$lang->loc['email.verify.6'].'
		</p>

		<p>'.$lang->loc['email.verify.7'] .'<br><br>
		'.$lang->loc['email.verify.8'].'<p>
		'.PATH.'/</p>

		<p>
		'.$lang->loc['email.verify.9'].' <a href="'.PATH.'/email?remove='.$hash.'">'.$lang->loc['email.verify.9.b'].'</a>.
		</p>

		<p>
		'.$lang->loc['email.verify.11'].'<a href="'.PATH.'/help">'.$lang->loc['email.verify.12'].'</a>.
		</p>';
		$mailer = new HoloMail;
		$mailer->sendSimpleMessage($to,$subject,$html);
		}else{
			$serverdb->query("UPDATE ".PREFIX."users SET email_verified = '1' WHERE id = '".$row[0]."' LIMIT 1");
		}
		
		// Referral
		if($refer == true){
			$data->update1($referrow[0],$settings->find("register_referral_rewards"));
			$db->query("INSERT INTO ".PREFIX."transactions (userid,time,amount,descr) VALUES ('".$referrow[0]."','".time()."','".$settings->find("register_referral_rewards")."','Referring a user.')");
			$data->insert2($row[0],$referrow[0]);
			$_SESSION['referral'] = $referrow[0];
		}

		$user = new HoloUser($name,$password,true);
		$_SESSION['user'] = $user;

		header("Location: ".PATH."/security_check?page=./welcome");

		exit; // cut off the script

		// And we're done!
	}


}
require_once('./templates/login_header.php');
?>
<div class="container content">
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-blue">
            <div class="panel-heading">
                <h1 class="panel-title">Registrierung: Start</h1>
            </div>
            <div class="panel-body">
                <div id="register-agb">
                    <p><b>Nutzungsbedingungen</b><br>
                        <a href="http://www.Habb0.ml/">www.Habb0.ml</a><br>
                        <br>
                        <b>1. Allgemeines</b><br>
                        <br>
                        <br>
                        Willkommen auf der Website <a href="http://www.Habb0.ml/">www.Habb0.ml</a>. Diese Nutzungsbedingungen gelten für jegliche Nutzung der Website <a href="http://www.Habb0.ml/">www.Habb0.ml</a> (nachfolgend 'Website' ) mit allen Unterseiten, Bereichen und Funktionen.<br>
                        <br>
                        Bei Habb0 handelt es sich um eine virtuelle Welt, die in erster Linie ihren Nutzern die Möglichkeit bietet, sich mit Hilfe einer selbst erstellten Figur in einem virtuellen Hotel zu bewegen, eigene Webpages selbst zu gestalten sowie mit anderen Nutzern zu kommunizieren.<br>
                        <br>
                        Solltest du mit diesen Nutzungsbedingungen nicht vollständig und uneingeschränkt einverstanden sein oder die hierin genannten Anforderungen nicht erfüllen, ist dir die Nutzung der Website nicht gestattet.</p>

                    <p><br>
                        <br>
                        <b>2. Registrierung / Anmeldung</b><br>
                        <br>
                        <br>
                        (1) Die wesentlichen Bereiche oder Funktionen der Website sind nur nach vorheriger Registrierung nutzbar. <br>
                        <br>
                        (2) Im Rahmen der Registrierung wählst du einen Benutzernamen und ein Passwort (nachfolgend 'Zugangsdaten'), über die du dich bei zukünftigen Besuchen auf der Website einloggen kannst. <br>
                        <br>
                        (3) Habb0 behält sich vor, einen Benutzernamen abzulehnen oder zu ändern, insbesondere wenn dieser bereits vergeben ist oder gegen die in Ziffer 3 (1) genannten Verbote verstoßen würde. Habb0 behält sich ferner das Recht vor, einen Benutzernamen nach Vertragsende neu zu vergeben. Eine Übertragung des Benutzernamens an einen anderen Nutzer ist unzulässig. <br>
                        <br>
                        (4) Habb0 behält sich vor, dir den Zugang bzw. die Registrierung zu verweigern, wenn du zuvor gegen diese Nutzungsbedingungen verstoßen hast, insbesondere nach einer Kündigung gemäß Ziffer 4 (3). <br>
                        <br>
                        (5) Sofern deiner Registrierung nichts entgegensteht, erhältst du direkten Zugriff auf unsere Seiten, sobald du Registrierung abgeschlossen hast, kommt ein Nutzungsvertrag zwischen dir und Habb0 zustande und dein Konto wird kurz darauf aktiviert. Durch den Abschluss dieses Nutzungsvertrages entstehen dir keine Kosten. <br>
                        <br>
                        <br>
                        <b>3. Eigene Inhalte</b><br>
                        <br>
                        <br>
                        (1) Du hast die Möglichkeit, auf der Website eigene Inhalte, insbesondere Texte und Kommentare, zu veröffentlichen bzw. dort anzeigen zu lassen oder zu versenden. Es ist jedoch strengstens untersagt, im Rahmen der Website Inhalte der nachfolgend genannten Art zu veröffentlichen bzw. dort anzeigen zu lassen oder zu versenden: <br>
                        <br>
                        - Inhalte, die Gewalt, Rassismus oder Diskriminierung verherrlichen, fördern, billigen oder verharmlosen; <br>
                        - nazistische Inhalte; <br>
                        - sexistische, pornographische sowie anstößige Inhalte; <br>
                        - erotische Inhalte, insbesondere Fotos, die eine Person zeigen, die im Zeitpunkt der Entstehung des Fotos das 18. Lebensjahr noch nicht vollendet hat; <br>
                        - jugendgefährdende Inhalte; <br>
                        - Links zu anderen Websites, Premium-Telefonnummern (z.B. 0900), SMS-Kurzwahlen, URLs und Adressen; <br>
                        - Inhalte, die Rechte Dritter, insbesondere Urheber- und Persönlichkeitsrechte (z.B. persönliche Informationen über einen anderen Usern oder einen Dritten), verletzen, sowie herabsetzende oder beleidigende Äußerungen; <br>
                        - Spam; <br>
                        - Daten, die geeignet sind, Schäden bei Habb0 oder Dritten auszulösen (z.B. Viren, Trojaner, Dialer); <br>
                        -Inhalte, mit denen deine gewerblichen oder finanziellen Interessen oder die eines Dritten gefördert werden; <br>
                        - Inhalte, die gegen geltendes Recht oder den Verhaltenskodex verstoßen oder einen Rechtsverstoß ermöglichen oder fördern.</p>

                    <p><br>
                        (2) Sofern du Inhalte auf der Website bereitstellst, die nach Ansicht von Habb0 gegen das vorgenannte Verbot verstoßen, und Habb0 hiervon Kenntnis erlangt, ist Habb0 berechtigt, <br>
                        <br>
                        <br>
                        (a) eine Veröffentlichung des betreffenden Inhalts abzulehnen, falls Habb0 der Verstoß vorher bekannt wird, <br>
                        (b) durch teilweises Bearbeiten oder Löschen den Verstoß zu beseitigen, <br>
                        (c) den Verstoß durch vollständiges Löschen des betreffenden Inhalts zu beseitigen, <br>
                        (d) dein Benutzerkonto ohne Ankündigung vorläufig oder endgültig zu sperren, <br>
                        (e) den mit dir geschlossenen Vertrag fristlos zu kündigen, sowie<br>
                        (f) die zuständigen Behörden, insbesondere Polizei und Staatsanwaltschaft, im rechtlich vorgesehenen Rahmen zu informieren und den Behörden sämtliche erforderlichen Daten zu übermitteln. Habb0 behält sich vor, Inhalte vor ihrer Veröffentlichung zu prüfen.</p>

                    <p><br>
                        (3) Soweit Inhalte Dritter rechtswidrig sind, insbesondere deine Rechte verletzen, solltest du Habb0 hierüber unverzüglich per E-Mail informieren. Eine solche Mitteilung muss mindestens folgende Informationen enthalten: <br>
                        <br>
                        <br>
                        - deinen Habb0 Usernamen, <br>
                        - Name des Habb0 Users, der den beanstandeten Inhalt veröffentlicht hat, <br>
                        - beanstandeter Inhalt einschließlich Erläuterung, inwieweit dieser deine Rechte verletzt, <br>
                        - genaue Beschreibung des Ortes innerhalb der Website, an dem der beanstandete Inhalt aufrufbar ist. <br>
                        <br>
                        <br>
                        Bei begründeten Beanstandungen wird Habb0 den fraglichen Inhalt unverzüglich nach Zugang der zur Identifizierung und Überprüfung der Beanstandung benötigten Daten von der Website nehmen bzw. den Zugang zu diesem Inhalt blockieren. Weitere Ansprüche gegen Habb0 aufgrund von Inhalten Dritter, insbesondere Schadenersatzansprüche, bestehen nicht.</p>

                    <p><br>
                        <br>
                        <b>4. Nutzungsdauer / Kündigung</b></p>

                    <p><br>
                        (1) Sowohl du selbst als auch Habb0 können das Vertragsverhältnis jederzeit fristlos und ohne Angabe von Gründen kündigen, sofern du nur Bereiche oder Funktionen der Website nutzt, für die keine Nutzungsgebühren anfallen. <br>
                        <br>
                        Eine Kündigung seitens Habb0 kann auch durch Löschung deines Benutzerkontos erfolgen. <br>
                        <br>
                        (2) Falls du einen kostenpflichtigen Bereich oder eine solche Funktion der Website nutzt, für die eine einmalige Vergütung zu entrichten ist, kannst du ebenfalls jederzeit fristlos und ohne Angabe von Gründen kündigen. Eine Spende ist freiwillig und wird nicht zurückerstattet für Fehler des Users haften wir nicht, kann der Benutzer nachweisen ob es sich um einen Fehler handelt erstattet Habb0 dem Benutzer den Betrag als Gutschein. <br>
                        <br>
                        (3) Nach einer Spende erhältst du als Geschenk den Zugriff auf einem speziellen Bereich oder eine solche Funktion der Website, kannst du selbst und Habb0 jederzeit das Vertragsverhältnis zum Ende der Laufzeit jeweils ohne Angabe von Gründen kündigen, beachte aber die Laufzeit besteht solange wie es Habb0 gibt. <br>
                        <br>
                        (4) Das Recht beider Vertragspartner zur fristlosen Kündigung aus wichtigem Grund nach den gesetzlichen Bestimmungen bleibt unberührt. Ein wichtiger Grund liegt für Habb0 insbesondere bei einem Verstoß deinerseits gegen die Bestimmungen in den Ziffern Ziffer 3 (1) und Ziffer 6 (3) dieser Nutzungsbedingungen sowie in den Fällen vor, in denen Habb0 einen begründeten Verdacht hat, dass die eingegebenen Nutzerdaten falsch oder diejenigen eines Dritten sind.</p>

                    <p><br>
                        <br>
                        <b>5. Nutzungsgebühren</b></p>

                    <p><br>
                        (1) Die Website besteht aus unterschiedlichen Bereichen oder Funktionen, die teilweise kostenpflichtig sind. Soweit Bereiche oder Funktionen kostenpflichtig sind, wird hierauf gesondert hingewiesen. <br>
                        <br>
                        Die Nutzung der Website setzt voraus, dass du Zugang zum Internet hast, durch den dir Kosten seitens deines Zugangsproviders entstehen können (z.B. Einwahl- sowie Anschlusskosten). <br>
                        <br>
                        (2) Für die Nutzung der Grundfunktionen der Website werden aktuell seitens Habb0 keine Nutzungsgebühren erhoben.. <br>
                        <br>
                        (3) Habb0 Sterne kannst du über die aktuell angebotene Bezahlmethode Paysafecard als Spende erhalten und zu den jeweils aktuell angegebenen Preisen erwerben. Die erworbenen Habb0 Sterne werden dir dann in deiner virtuellen Geldbörse gutgeschrieben. <br>
                        <br>
                        Du kannst nur diejenigen Habb0 Sterne einsetzen, die sich aktuell in deiner Geldbörse befinden. <br>
                        <br>
                        Habb0 weist ausdrücklich darauf hin, dass du sofern du noch nicht volljährig bist zum Erwerb der Habb0 Sterne unbedingt im Voraus die Zustimmung deiner Eltern oder desjenigen einholen musst, der für die Habb0 Sterne bezahlen soll. Wenn du dich nicht daran hältst, ist Habb0 berechtigt, dein Benutzerkonto ohne Ankündigung vorläufig oder endgültig zu sperren sowie den mit dir geschlossenen Vertrag fristlos zu kündigen. <br>
                        <br>
                        (4) Habb0 behält sich ausdrücklich vor, bereits vorhandene oder modifizierte Bereiche bzw. Funktionen in der Zukunft gegen Nutzungsgebühren anzubieten. Habb0 wird dich hierüber einen Monat im Voraus informieren.</p>

                    <p><br>
                        <br>
                        <b>6. Deine Pflichten</b></p>

                    <p><br>
                        (1) Du bist verpflichtet, deine Zugangsdaten streng vertraulich zu behandeln und diese keinem Dritten zugänglich zu machen und ein sicheres Passwort mit Sonderzeichen zu benutzen. <br>
                        <br>
                        Solltest du den Verdacht oder die Gewissheit haben, dass ein Dritter Zugang zu deinen Zugangsdaten hatte, ist Habb0 unverzüglich per E-Mail darüber zu informieren. Sollten dir die Zugangsdaten eines anderen Users bekannt werden, ist es dir auch im Falle einer Erlaubnis durch den anderen User untersagt, dich mit diesen Zugangsdaten anstelle deiner eigenen anzumelden. <br>
                        <br>
                        Du haftest für alle Schäden, die durch eine missbräuchliche Nutzung deiner Zugangsdaten bis zur Anzeige gegenüber Habb0 entstehen. <br>
                        <br>
                        (2) Darüber hinaus bist du verpflichtet, die im Rahmen der Registrierung gemachten Angaben zu deiner Person wahrheitsgemäß zu machen und aktuell zu halten. Im Falle von Änderungen sind die entsprechenden Angaben in deinem Habb0-Profil anzupassen (z.B. Wechsel der E-Mail-Adresse). <br>
                        <br>
                        (3) Die Website steht dir zum privaten und bestimmungsgemäßen Gebrauch zur Verfügung. Andere Nutzungen sind ausdrücklich untersagt, wie zum Beispiel: <br>
                        <br>
                        <br>
                        - gewerbliche Nutzung (Zugänglichmachen einzelner Bereiche oder Funktionen gegen Entgelt), <br>
                        -Auslesen von E-Mail-Adressen und Inhalten, insbesondere mittels technischer Hilfsmittel wie z.B. Hard- oder Software<br>
                        - Kontaktieren von Usern in anderer Weise als auf der Website im Rahmen des bestimmungsgemäßen Gebrauchs vorgesehen (z.B. keine Massen-E-Mails bzw. Spam), <br>
                        - Nutzung von Inhalten anderer User ohne deren Einwilligung, <br>
                        - Integration von Werbung in die eigenen Inhalte, <br>
                        - Übermittlung oder Veröffentlichung von Werbung jeglicher Art, <br>
                        - Übertragung von schädlichen Daten oder Dateien, wie z.B. Viren, Trojaner, <br>
                        - Änderungen an der Website, <br>
                        - rechtswidrige Nutzungen (vgl. z.B. Ziffer 7 (3) und (4)). <br>
                        <br>
                        <br>
                        (4) Die Website bietet die Möglichkeit, mit anderen Usern zu kommunizieren und ihren Auftritt bzw. Mitteilungen zu kommentieren. Es ist dir hierbei untersagt, in diesem Zusammenhang Inhalte zu veröffentlichen, die Rechte Dritter verletzen, insbesondere falsche Tatsachenbehauptungen sowie verleumderische, beleidigende oder auf sonstige Weise ehrverletzende Meinungsäußerungen. <br>
                        <br>
                        (5) Bei einem Verstoß gegen die in (1) bis (4) genannten Pflichten gilt Ziffer 3 (2) entsprechend. <br>
                        <br>
                        (6) Du bist dafür verantwortlich, dass zum Zeitpunkt der Nutzung der Website mit ihren Bereichen und Funktionen (nachfolgend 'Angebot') die jeweils aktuellen Systemvoraussetzungen erfüllt sind. Insoweit weist Habb0 darauf hin, dass die Installation des kostenlosen Flash Players von Adobe Systems Incorporated in der aktuellsten Version erforderlich ist. Dieses Programm ist nicht Bestandteil des Habb0 Angebots. <br>
                        <br>
                        Durch Änderungen des Angebots kann es erforderlich werden, dass die Systemvoraussetzungen angepasst werden müssen, um das Angebot weiterhin nutzen zu können. Es obliegt dir, die hierzu erforderlichen Maßnahmen auf eigene Kosten zu ergreifen (insbesondere Software-Updates). Der Bezug und die Installation der oben genannten Software sowie weiterer Programme oder Programmbestandteile (z.B. Plug-In), deren Installation zu einem späteren Zeitpunkt zur Nutzung der Website erforderlich werden kann, erfolgt in deiner Verantwortung und auf deine Gefahr. <br>
                        <br>
                        (7) Im Rahmen der Website besteht die Möglichkeit zu Interaktionen mit anderen Usern (z.B. Tauschgeschäfte). Für manche Aktionen gelten besondere Nutzungsbedingungen oder Verhaltensregeln, die unbedingt einzuhalten sind. Weitere Informationen dazu findest du auf den FAQ-Seiten auf <a href="http://www.Habb0.ml/">www.Habb0.ml</a><br>
                        <br>
                        <br>
                        <b>7. Nutzungsrechte</b></p>

                    <p><br>
                        (1) Mit dem Upload, der Darstellung oder sonstigen Integrierung von Inhalten auf der Website räumst du Habb0 unentgeltlich das örtlich und zeitlich unbeschränkte, nicht-ausschließliche Recht ein, diese Inhalte auf und in Zusammenhang mit der Website (einschließlich der Bewerbung der Website und sonstiger geschäftlicher Tätigkeiten von Habb0 mit Bezug zu der Website) zu nutzen. Dies umfasst insbesondere das Recht, die Inhalte zu speichern, zu bearbeiten (insbesondere in andere Dateiformate zu übertragen), zu ändern, zu vervielfältigen, zu übertragen, zu veröffentlichen, zu verbreiten, öffentlich zugänglich zu machen, zu senden, aufzuführen und zum Download bereitzuhalten und/oder mittels technischer Einrichtungen verfügbar zu machen und dieses Angebot in allen Medien zu bewerben (auch unter Darbietung bzw. Darstellung der Inhalte). Die Lizenzierung umfasst insbesondere auch das Recht seitens Sulake, die Inhalte<br>
                        <br>
                        <br>
                        a) in digitale Datennetze (z. B. Internet) einzuspeisen; <br>
                        <br>
                        b) im Anschluss an eine Datenfernübertragung über Datennetze im Sinne von a) am Ort des Endkunden vollständig oder teilweise wiederzugeben oder wahrnehmbar zu machen ('Online prelistening' bzw. 'Online previewing'); <br>
                        <br>
                        c) zum Zwecke der dauerhaften Speicherung (Downloading) via Datennetze (einschließlich Mobilfunk) zu übermitteln. <br>
                        <br>
                        <br>
                        Du räumst Sulake außerdem das Synchronisationsrecht bezüglich der Inhalte ein; Sulake ist berechtigt, die Inhalte mit einem beliebigen anderen Werk, insbesondere einem Bild-, Musik-, Filmwerk oder einer Sprachaufnahme zu verbinden und so, insbesondere im Rahmen von Werbemaßnahmen, zu nutzen. <br>
                        <br>
                        Die Rechteeinräumung umfasst nicht das Recht seitens Sulake, die Inhalte Dritten entgeltlich zu überlassen, sofern dies nicht im Zusammenhang mit der Website erfolgt. <br>
                        <br>
                        (2) Sulake ist berechtigt, die gemäß (1) von dir eingeräumten Rechte einem oder mehreren mit Sulake im Sinne von § 15 AktG verbundenen Unternehmen sowie sonstigen Dritten, derer sich Sulake zur Erbringung und Abrechnung der mit der Website verbundenen Leistungen bedient, einzuräumen, d.h. zu sub-lizenzieren. <br>
                        <br>
                        (3) Du erkennst an, dass sowohl die Website als auch die dort dargestellten und aufrufbaren Elemente und Inhalte von Habb0, anderen Usern oder sonstigen Dritten durch Rechte zum Schutz geistigen Eigentums (gewerbliche Schutzrechte) insbesondere Urheberrechte geschützt sind. Du bist mit Ausnahme der von dir selbst bereitgestellten Inhalte nicht berechtigt, im Rahmen der Website zugänglich gemachte, vor allem auf der Website dargestellte Inhalte von Sulake, anderen Usern oder sonstigen Dritten zu nutzen, insbesondere, diese zu kopieren, zu speichern, zu bearbeiten und/oder zu vertreiben, es sei denn dies erfolgt mit ausdrücklicher schriftlicher Erlaubnis von Habb0. <br>
                        <br>
                        (4) Es ist dir u.a. nicht gestattet, ohne vorherige schriftliche Zustimmung von Habb0<br>
                        <br>
                        <br>
                        a) die Website oder Teile davon (insbesondere Inhalte, wie Fotos, Videos etc.) im Wege der Verlinkung oder des Framings in eigene oder fremde Internetangebote einzubinden oder auf sonstige Weise darzustellen oder<br>
                        <br>
                        b) die Website oder Teile davon (insbesondere Inhalte, wie Fotos, Videos etc.) zu kopieren oder nachzuprogrammieren, insbesondere im Wege des 'reverse engineering', <br>
                        <br>
                        c) im Internet entgeltlich oder unentgeltlich Leistungen anzubieten, die sich auf die Website beziehen und durch die der irrige Eindruck erzeugt wird, hierdurch erhielte der Nutzer Vorteile für seinen User oder die Leistung würde mit Zustimmung von oder in Zusammenarbeit mit Habb0 erbracht. <br>
                        <br>
                        d) der An- und Verkauf von Habb0 Artikeln wie z.B. Möbel, Taler, Talercodes, Accounts, ist sowohl im privaten Rahmen als auch auf Tauschbörsen, (Internet-) Auktionshäusern und sonstigen Marktplätzen, sowie privaten Websites nicht erlaubt. <br>
                        <br>
                        (5) Bei einem Verstoß gegen die in (3) und (4) genannten Pflichten gilt Ziffer 3 (2) entsprechend.</p>

                    <p><br>
                        <br>
                        <b>8. Freistellung / Nutzerhaftung</b></p>

                    <p><br>
                        (1) Du bist verantwortlich und haftbar für die unter deinem Benutzernamen auf der Website angezeigten Inhalte, wie beispielsweise Texte. <br>
                        <br>
                        Soweit du im Rahmen der Website Inhalte hochlädst oder auf sonstige Weise in die Website integrierst, versicherst du insbesondere, dass hierdurch keine Rechte Dritter, vor allem Urheber- und Leistungsschutzrechte sowie Persönlichkeitsrechte und/oder das Recht am eigenen Bild verletzt werden. Du versicherst ferner, Inhaber sämtlicher Rechte zu sein, die du Habb0 gemäß Ziffer 7 einräumst, und dass du zur Einräumung dieser Rechte vollumfänglich berechtigt bist. <br>
                        <br>
                        (2) Kommt es aufgrund eines schuldhaften Verstoßes deinerseits gegen diese Nutzungsbedingungen, insbesondere gegen deine in Ziffern 3 (1), 6 und 8 (1) bestimmten Pflichten, zur Geltendmachung von Ansprüchen Dritter, so bist du verpflichtet, Sulake von sämtlichen diesbezüglichen Ansprüchen Dritter sowie in diesem Zusammenhang entstehenden weiteren Schäden, Kosten und Aufwendungen (einschließlich der bei einer Verteidigung gegen den Anspruch anfallenden angemessenen Rechtsanwalts- und Gerichtskosten) freizustellen. <br>
                        <br>
                        <br>
                        <b>9. Leistungsumfang</b></p>

                    <p><br>
                        (1) Habb0 stellt dir das Angebot in der jeweils aktuellen Version auf der Grundlage dieser Nutzungsbedingungen zur Verfügung. Da Habb0 stets bemüht ist, sein Leistungsangebot zu verbessern, kann es zu Änderungen, Ergänzungen und Umstellungen des Angebots kommen. Im Falle wesentlicher Änderungen wird sich Habb0 bemühen, dich rechtzeitig im Voraus zu informieren. <br>
                        <br>
                        Neue Bereiche und Funktionen werden dir dabei ebenfalls auf der Grundlage dieser Nutzungsbedingungen angeboten. Soweit neue Bereiche und Funktionen auf der Grundlage besonderer Nutzungsbedingungen (nachfolgend 'Besondere Nutzungsbedingungen') zur Verfügung gestellt werden, gelten die besonderen Nutzungsbedingungen neben diesen Nutzungsbedingungen; bei Überschneidungen und Widersprüchen gehen die besonderen Nutzungsbedingungen vor. <br>
                        <br>
                        (2) Aus regulatorischen, technischen oder wirtschaftlichen Gründen behält sich Habb0 außerdem vor, das Angebot teilweise oder ganz einzustellen. Soweit hiervon ein kostenpflichtiger Teil des Angebots betroffen ist und kein gleichwertiger Ersatz angeboten wird, erfolgt die Einstellung unter Beachtung von Ziffer 4 sowie gegebenenfalls gegen Erstattung eines eventuell noch vorhandenen Guthabens, wenn dieses aufgrund der Einstellung für Dich nicht mehr nutzbar ist. <br>
                        <br>
                        <br>
                        <br>
                        <b>10. Gewährleistung / Haftung des Anbieters</b></p>

                    <p><br>
                        (1) Habb0 kann nicht gewährleisten, dass die Website jederzeit unterbrechungsfrei verfügbar ist sowie fehler- und störungsfrei funktioniert. Aufgrund von technischen Umständen, die nicht im Einflussbereich von Habb0 liegen, kann es zu Ausfällen, insbesondere zu einer zeitweisen Nichterreichbarkeit des Internet oder der Website, kommen. Dies gilt auch im Falle von Wartungsmaßnahmen und Aktualisierungen. Du erklärst Dich mit derartigen Maßnahmen, die nach Möglichkeit außerhalb der üblichen Geschäftszeiten vorgenommen und rechtzeitig angekündigt werden, und den hiermit verbundenen Beeinträchtigungen in vertretbarem Umfang einverstanden. Eine solche vorübergehende Nichterreichbarkeit der Website begründet keinen Mangel. <br>
                        <br>
                        (2) Habb0 haftet nicht für Datenverluste oder -löschungen, die nicht im Einflussbereich von Habb0 liegen. <br>
                        <br>
                        (3) Habb0 haftet dir gegenüber auf Schadenersatz gleich aus welchem Rechtsgrund nur bei Vorsatz, grober Fahrlässigkeit und leicht fahrlässiger Verletzung wesentlicher Vertragspflichten durch Habb0 selbst, durch einen gesetzlichen Vertreter oder Erfüllungsgehilfen. Bei leicht fahrlässiger Verletzung wesentlicher Vertragspflichten ist die Haftung begrenzt auf den Ersatz des vertragstypischen, vorhersehbaren Schadens. Darüber hinaus ist eine Haftung des Anbieters ausgeschlossen. Insbesondere mittelbare Schäden werden nicht ersetzt. <br>
                        Die vorstehenden Haftungsbeschränkungen gelten nicht für solche von Habb0, einem gesetzlichen Vertreter oder Erfüllungsgehilfen schuldhaft verursachte Schäden aus der Verletzung des Lebens, des Körpers oder der Gesundheit sowie für die Haftung nach dem Produkthaftungsgesetz. <br>
                        <br>
                        (4) Soweit im Rahmen der Website veröffentlichte Inhalte von anderen Usern oder Dritten (z.B. externen Experten) stammen, übernimmt Habb0 keine Gewähr für die Richtigkeit, Vollständigkeit und Rechtmäßigkeit dieser Inhalte, da diese vor ihrer Veröffentlichung nicht überprüft werden. <br>
                        <br>
                        Des Weiteren geben von Usern oder Dritten (z.B. externen Experten) im Rahmen der Website geäußerte und veröffentlichte Meinungen nicht die Meinung von Habb0 wieder.</p>

                    <p><br>
                        <br>
                        <b>11. Inhalte Dritter</b></p>

                    <p><br>
                        (1) Im Rahmen des Angebots kann es zur Einbindung von Inhalten Dritter (z.B. Banner, Links, Micro-Sites) kommen. Habb0 macht sich weder diese Inhalte noch solche Inhalte zu eigen, die durch Verlinken erreicht werden können. Habb0 übernimmt keine Gewähr oder Haftung für solche Inhalte. <br>
                        <br>
                        (2) Sofern im Rahmen der Website Leistungen Dritter angeboten werden, kommt im Falle einer Inanspruchnahme ein Vertrag zwischen dir und dem Dritten zustande. Habb0 hat keinen Einfluss auf diese Leistungen oder ihre Erbringung. (1) Satz 2 gilt entsprechend.</p>

                    <p><br>
                        <br>
                        <b>12. Datenschutz</b></p>

                    <p><br>
                        (1) Die seitens Habb0 abgefragten Daten zu deiner Person werden entsprechend den Habb0 Datenschutzrichtlinien und dem geltenden Datenschutzrecht erhoben, gespeichert, verarbeitet und gelöscht. <br>
                        <br>
                        (2) Soweit du dich mit der Geltung der Habb0 Datenschutzrichtlinien im Rahmen der Registrierung einverstanden erklärt hast, kannst du diese Zustimmung jederzeit per E-Mail widerrufen. <br>
                        <br>
                        <br>
                        <b>13. Widerrufsbelehrung</b></p>

                    <p><br>
                        <br>
                        <b>Widerrufsrecht</b><br>
                        <br>
                        Du kannst deine Vertragserklärung innerhalb von 2 Wochen ohne Angabe von Gründen in Textform (z.B. Brief, Fax oder E-Mail) widerrufen. Die Frist beginnt frühestens mit Erhalt dieser Belehrung. Zur Wahrung der Widerrufsfrist genügt die rechtzeitige Absendung des Widerrufs an die folgende E-Mail Adresse: admin@Habb0.ml<br>
                        <br>
                        <br>
                        <b>Widerrufsfolgen</b><br>
                        <br>
                        Im Falle eines wirksamen Widerrufs sind die beiderseits empfangenen Leistungen zurückzugewähren und ggf. gezogene Nutzungen herauszugeben. Kannst du Habb0 die empfangene Leistung ganz oder teilweise nicht oder nur in verschlechtertem Zustand zurück gewähren, musst du Habb0 insoweit ggf. Wertersatz leisten in Art eines Gutscheins. Verpflichtungen zur Erstattung von Zahlungen musst du innerhalb von 30 Tagen nach Absendung deiner Widerrufserklärung erfüllen.<br>
                        Dein Widerrufsrecht erlischt vorzeitig, wenn Habb0 mit der Ausführung der Dienstleistung mit deiner ausdrücklichen Zustimmung vor Ende der Widerrufsfrist begonnen hat oder du diese selbst veranlasst hast.</p>

                    <p><br>
                        <br>
                        -- Ende der Widerrufsbelehrung --</p>

                    <p><br>
                        <br>
                        <b>14. Schlussbestimmungen</b></p>

                    <p><br>
                        (1) Die Habb0 Datenschutzrichtlinien, der Verhaltenskodex ('Regeln') sowie sämtliche Besonderen Nutzungsbedingungen für spezielle Bereiche oder Funktionen dieser Website sind ebenfalls Bestandteil dieser Nutzungsbedingungen. Soweit es zu Widersprüchen zwischen den besonderen Nutzungsbedingungen und den vorstehenden Bedingungen kommt, gehen die besonderen Nutzungsbedingungen insoweit vor. <br>
                        <br>
                        (2) Habb0 behält sich das Recht vor, diese Nutzungsbedingungen von Zeit zu Zeit anzupassen. Du erhältst dann eine Mitteilung bezüglich der vorgenommenen Änderungen. Diese Änderungen gelten als genehmigt, wenn Du<br>
                        <br>
                        a) diesen Änderungen (z.B. im Rahmen eines Dialogs auf der Website) ausdrücklich zustimmst oder<br>
                        <br>
                        b) diesen Änderungen nicht binnen 4 Wochen ab Zugang der Änderungs-mitteilung per E-Mail widersprichst. <br>
                        <br>
                        (3) Habb0 ist berechtigt, das Angebot ganz oder teilweise auf einen Dritten zu übertragen, der dann dir gegenüber das Angebot oder Teile hiervon anbietet. Soweit das Angebot insgesamt übertragen wird, tritt der übernehmende Dritte anstelle von Habb0 in den zwischen dir und Habb0 geschlossenen Vertrag ein. Dir wird dabei rechtzeitig die Möglichkeit eingeräumt, den Vertrag zu kündigen und so eine Übernahme deines Vertragsverhältnisses zu verhindern. <br>
                        <br>
                        (4) Es gilt deutsches Recht. <br>
                        <br>
                        <br>
                        *gültig seit 14.04.2012</p>
                </div>
				<?php if(empty($_POST['register-username']))
					{ 
				?>
				<div class="alert alert-danger"><?php echo $fehler;?></div>
				<?php
				}
				?>
				
                                <form action="#" name='registration' method="POST" role="form">                <div style="display: none;">
                    <input type="hidden" id="csrf" name="YjJZOHBnNXhRb1JuUG1ZRFUwOHhnUT09" value="elhJbXd2ZzUyV0N4M3YzOFdhSFFmUT09">                </div>
                <div class="row">
                    <div class="col-md-2 text-center">
                        <img src="http://Habb0.ml/img/frank-hello.png" class="hello-frank" alt="Welcome Frank">                        <div class="text-justify max-width">
                            Registriere dich hier bei uns! Du wirst es nicht bereuen. Wir freuen uns schon auf dich und heißen dich herzlich Willkommen.                            <a href="<?php echo PATH;?>" class="btn btn-block btn-warning">&laquo; Abbrechen</a>                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="register-username">Benutzername</label>
                            <input type="text" id="register-username" name="register-username" class="form-control" value="<?php echo $_SESSION['bean_avatarName']; ?>" maxlength="255" placeholder="Benutzername eingeben ...">                        </div>
							<input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                        <div class="form-group">
                            <label for="register-email">E-Mail Adresse</label>
                            <input type="email" id="register-email" name="register-email" class="form-control" value="<?php echo $_SESSION['bean_email']; ?>" maxlength="255" placeholder="E-Mail Adresse angeben ...">                        </div>
                        <div class="form-group">
                            <label for="register-password">Passwort</label>
                            <input type="password" id="register-password" name="register-password" class="form-control" maxlength="32" placeholder="Gewünschtes Passwort eingeben ...">                        </div>
                        <div class="form-group">
                            <label for="register-password-repeat">Passwort wiederholen</label>
                            <input type="password" id="register-password-repeat" name="register-password-repeat" class="form-control" maxlength="32" placeholder="Gewünschtes Passwort wiederholen ...">                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="register-agb" class="sr-only"></label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="register-agb" name="register-agb"> AGBs akzeptieren <a href="javascript:;" id="register-agb-read">lesen &raquo;</a>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="register-captcha">Sicherheitsmaßnahme</label>
                            <div class="g-recaptcha" data-sitekey="6LethRoTAAAAAEp8Oql0Sxk_Wb3zJMeWTWi0ncg_"></div>                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
                        <div class="form-group">
                            <input type="submit" name="login_user" value="Registrierung abschließen" class="btn btn-success btn-block">                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="http://Habb0.ml/img/Front1.png" alt="Freunde finden">            <div class="caption">
                <h3>Freunde finden</h3>
                <p>Finde neue und tolle Freunde im Habb0. Spiele oder chatte mit ihnen und habt Spaß miteinander!</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="http://Habb0.ml/img/Front3.png" alt="Events beitreten">            <div class="caption">
                <h3>Keine versteckten Kosten</h3>
                <p>Im Habb0 erhälst du jede 15 Minuten kostenlos Taler die du im Katalog ausgeben kannst, dass heißt du musst kein Geld für Taler ausgeben!</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="thumbnail">
            <img src="http://Habb0.ml/img/Front2.png" alt="Räume bauen">            <div class="caption">
                <h3>Räume bauen</h3>
                <p>Sammle und tausche deine Möbelstücke mit deinen Freunden oder anderen Mitspielern, um damit tolle Räume bauen zu können. Zeige deinen Mitspielern deine Errungenschaften!</p>
            </div>
        </div>
    </div>
</div> 
<?php

require('./templates/login_footer.php');

?>
