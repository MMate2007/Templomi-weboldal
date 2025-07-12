<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<meta name="title" content="Főoldal - <?php echo $sitename; ?>">
<title><?php echo $sitename; ?></title>
<meta name="description" content="A szentmise vasárnap általában rggel 8 órakor van. Ez a fília a somlóvásárhelyi plébániához tartozik. Plébánosa: Németh József atya.">
<meta name="language" content="hu-HU">
<!--TODO meta:keywords, meta:description mezők frissítése-->
<!--TODO új jogosultságrendszer kezelése-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
div.fejlecparallax {
	background-image: url("<?php echo getheadimage(); ?>");
	/*TODO getheadimage() function beépítése a többi oldalra*/
}
</style>
</head>
<body>
<?php
if (isset($_SESSION["userId"])) {
	?>
	<div id="messagesdiv">
		<?php
		Message::displayall();
		?>
	</div>
	<?php
}
?>
<header class="h-100">
<div class="head h-100">
<div class="fejlecparallax text-center bg-image h-100">
<?php
include("navbar.php");
?>
<div class="head-text d-flex justify-content-center align-items-center h-100 mask">
<div class="text-white" id="introdiv">
	<div>
		<h1 class="text-center text-white" style="font-variant: small-caps; padding-bottom: 10px;">Dicsértessék a Jézus Krisztus!</h1>
		<h1 class="text-center text-white" style="padding-bottom: 10px;">Üdvözöljük <?php echo $sitename; ?> weboldalán!</h1>
		<a class="btn btn-outline-light btn-lg m-2" id="miserendgombindex" href="miserend.php" title="Ide kattintva megtudhatja, hogy mikor tartanak szentmiséket, szentségimádásokat, stb.">Miserend</a>
		<a class="btn btn-outline-light btn-lg m-2" id="hirdetesgombindex" href="hirdetesek.php" title="Ide kattintva megtekintheti a hirdetéseket.">Hirdetések</a>
		<?php
	$fb = getsetting("facebook.username");
	if ($fb != null) {
		?>
		<a id="facebooklinkinhead" href="https://facebook.com/<?php echo $fb; ?>" target="_blank" title="Az egyházközség Facebook-oldala." style="padding-top: 10px;">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
				<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
			</svg>
			<?php echo $fb; ?>
		</a>
		<?php
	}
	?>
	</div>
	<a href="#content" id="nyilacska">
		<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16" style="position: absolute; bottom: 5%; left: 48.8%;">
			<path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
		</svg>
	</a>
</div>
</div>
</div>
</div>
</header>
<main class="content" id="content" style="margin-right: 0px;">
<!-- TODO egy ötlet: lehetne 3-as felosztásban megjeleníteni a közelgő szentmiséket (csak azokat), a hirdetéseket és a legfrissebb bejegyzéseket -->
</main>
<?php include("footer.php"); ?>
</body>
</html>