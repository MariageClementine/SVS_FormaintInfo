<?php
include_once("includes/config.inc.php");
include_once("includes/lib_mail.inc.php");
if(!isset($_POST['submit'])) {
	$formMsg="Pour recevoir une r&eacute;ponse rapide, compl&eacute;tez le formulaire ci-dessous:";
	$formMsgClass="normal";
} else {
	# traitement du formulaire et construction du message envoyé par email
	include_once("includes/lib_forms.inc.php");
	if(!checkMail($_POST['email'])) {
		$formMsg="Une adresse email valide est requise<br />";
		$formMsgClass="messageErr";
		$errForm=1;
	}

	if(!validLenField($_POST['nom'], "Nom", 3, 32)) {
		$formMsg .="Pour obtenir une r&eacute;ponse nous avons besoin de conna&icirc;tre votre nom<br />";
		$formMsgClass="messageErr";
		$errForm=1;
	}

	if(!validLenField($_POST['prenom'], "Prenom", 3, 32)) {
		$formMsg .="Pour obtenir une r&eacute;ponse nous avons besoin de conna&icirc;tre votre pr&eacute;nom<br />";
		$formMsgClass="messageErr";
		$errForm=1;
	}

	if(!$errForm==1) {
		# ben alors c'est bon...
		$mailBody="<p><b>DEMANDE D'INFORMATION</b><br />Nom: " . stripslashes($_POST['nom']) . "<br />Pr&eacute;nom: " . stripslashes($_POST['prenom']) . "<br />Adresse: " . stripslashes($_POST['adresse']) . "<br />T&eacute;l&eacute;phone: " . $_POST['telephone'] . "<br />E-mail: <a href='mailto:" . $_POST['email'] . "'>" . $_POST['email'] . "</a></p>";
		$mailBody .="<p>Type d'intervention souhait&eacute;e: " . $_POST['type_intervention'] . "<br />Syst&egrave;me d'exploitation: " . $_POST['OS'] . "</p>";

		if(!empty($_POST['message'])) {
			$mailBody .="<p>La demande est accompagn&eacute;e du message suivant:<br />" . $_POST['message'] . "</p>";
		}		
		if(sendMail($emailFormInfo, "[formaintinfo.com] Demande d'info", $mailBody, $_POST['email'])) {
			$formMsg="L'envoi du message &agrave; &eacute;chou&eacute;. R&eacute;&eacute;ssayez ult&eacute;rieurement.";
			$formMsgClass="messageErr";
		} else {
			$formMsg="Votre message a bien &eacute;t&eacute; envoy&eacute;. Vous serez contact&eacute; tr&egrave;s prochainement.";
			$formMsgClass="messageOk";
		}
	}

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Contactez Formaint'info</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?php include_once("includes/meta_common.inc.php"); ?>
	<meta name="description" lang="fr" content="Page de contact de Formaint'info: toutes les coordonnées" />
	<meta name="keywords" lang="fr" content="informatique, formaint'info, gap, Gap, web, site, windows" />
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
	<!--modification du script-->
	<link rel="shortcut icon" href="faviconFormaint.ico">
	<link rel="icon" type="image/gif" href="faviconFormaint.gif" />
<!-- fin de modification-->
</head>
<body>


<!--modification du script-->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
	
<!--fin de modification-->


			<div id="page">
				<?php include_once("includes/header.inc.php"); ?>
				<div id="titrePage">
					<h1>Toutes les coordonn&eacute;es pour contacter Formaint'info</h1>
				</div><!-- fin div titrePage-->
				<div id="zonemenu">
					<?php include_once("includes/menu.inc.php"); ?>
				</div><!-- fin div zonemenu-->
			</div><!-- fin div page-->
			<div id="colonne1">
				<h2>Remplissez notre formulaire</h2>
				<p class="<?php echo $formMsgClass; ?>"><?php echo $formMsg; ?></p>
				<p>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
				<h3>Vos coordonn&eacute;es:</h3>
				<p>
				<table cellpadding="3" cellspacing="0" border="0" align="center">
				<tr>
					<td>Nom: </td>
					<td><input type="text" name="nom" size="20" maxlength="32" /></td>
				</tr>
				<tr>
					<td>Pr&eacute;nom: </td>
					<td><input type="text" name="prenom" size="20" maxlength="32" /></td>
				</tr>
				<tr>
					<td>Soci&eacute;t&eacute;: </td>
					<td><input type="text" name="societe" size="20" maxlength="32" /></td>
				</tr>
				<tr>
					<td>Adresse: </td>
					<td><textarea name="adresse" rows="5" cols="30"></textarea></td>
				</tr>
				<tr>
					<td>T&eacute;l&eacute;phone: </td>
					<td><input type="text" name="telephone" size="14" maxlength="14" /></td>
				</tr>
				<tr>
					<td>E-mail: </td>
					<td><input type="text" name="email" id="email" size="20" maxlength="64" /></td>
				</tr>
				</table>
				</p>
				<br />
				<h3>L'intervention que vous envisagez:</h3>
				<p>
				<table cellpadding="3" cellspacing="0" border="0" align="center">
				<tr>
					<td>Type: </td>
					<td>
						<select name="type_intervention">
							<option value="0" label="Votre choix" selected>--- Votre choix ---</option>
							<option value="Depannage" label="D&eacute;pannage">D&eacute;pannage</option>
							<option value="Installation" label="Installation">Installation</option>
							<option value="Achat_materiel" label="Achat de mat&eacute;riel informatique">Achat de mat&eacute;riel informatique</option>
							<option value="formation" label="Formation">Formation</option>
							<option value="Creation_site" label="Cr&eacute;er un site web">Cr&eacute;er un site web</option>
							<option value="Renseignement" label="Renseignement">Renseignement</option>
							<option value="Autre" label="Autre">Autre</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Vous utilisez: </td>
					<td>
						<select name="OS">
							<option value="0" label="Votre choix" selected>--- Votre système d'exploitation ---</option>
							<option value="winXP" label="Windows XP">Windows XP</option>
							<option value="Win2003S" label="Windows 2003 server">Windows 2003 server</option>
							<option value="Win2000" label="Windows 2000">Windows 2000</option>
							<option value="winNT" label="Windows NT">Windows NT</option>
							<option value="winME" label="Windows Millenium">Windows Millenium</option>
							<option value="win98" label="Windows 98">Windows 98</option>
							<option value="win95" label="Windows 95">Windows 95</option>
							<!-- modification du script-->
							<option value="win7"  label="Windows 7">Windows 7</option>
							<option value="win8"  label="Windows 8">Windows 8</option>
							<option value="mac"   label="Mac OS">Mac OS</option>
							<!-- fin de modification-->
							<option value="linux" label="Linux">Linux</option>
						</select>
					</td>
				</tr>
				</table>
				</p>
				<p>
				<h3>Votre message:</h3>
				<p>Accompagnez votre demande par un message. N'h&eacute;sitez-pas &agrave; &ecirc;tre pr&eacute;cis:</p>
					<textarea name="message" rows="5" cols="45"></textarea>
				</p>
				<p class="pCenter"><input type="submit" name="submit" value="Envoyer" class="button"/> <input type="reset" value="Effacer tout" class="button"/></p>
				</form>
			</div><!--fin div colonne1-->
			<div id="colonne2">
				<h2>Toutes nos coordonn&eacute;es</h2>
				<h3>Par email</h3>
				<p>Pour nous contacter cliquer sur le lien suivant : <a href="mailto:infos@formaintinfo.com">infos@formaintinfo.com</a></p>
				<h3>T&eacute;l&eacute;phone et fax</h3>
				<p>T&eacute;l&eacute;phonez-nous au :
					<ul>
						<li>06 12 95 92 42</li>
						<li>ou au 09 53 71 52 14 (tarif local en France)</li>
					</ul>
					Ou envoyez-nous un fax au : 04 92 43 52 14
				</p>
				<p>&nbsp;</p><p align="center"><img src="images/ordi2.gif" width="113" height="123" alt="Toutes nos corrdonn&eacute;es" title="Toutes nos corrdonn&eacute;es" /></p><p>&nbsp;</p>
				<!-- modification du script-->
				<p class="pCenter">SIRET : 478 945 066 00023 - APE : 6209 Z</p>
				<?php include("includes/salp.inc.php"); ?></br>
				<!-- fin de modification-->
				</p>
			</div><!-- fin div colonne2-->


<!--modification du script-->
		
		<div id="colonne3" align="center">
			<div class="fb-like-box" data-href="https://www.facebook.com/formaintinfo?fref=ts" data-width="800" data-height="420" data-show-faces="true" data-stream="true" data-show-border="true" data-header="true"></div>
		</div><!-- fin div colonne3-->
	
<!--fin de modification-->


</body>
</html>
