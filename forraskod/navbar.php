<?php if(!isset($_COOKIE['enablecookie']))
{ ?>
<div id="cookie">
  <p>Ez a webhely sütiket (HTTP Cookies) használ bizonyos funkciókhoz. Ha elutasítja a sütiket, hibaüzenetek jelenhetnek meg (de nem létfontosságú funkciók válnak használhatatlanná ezáltal; <b>A bejelentkezés sütik nélkül nem működik!</b>; Elutasításkor 1 süti még életben marad, azt nem lehet letiltani (_ga)).</p><form action="cookie.php" method="post"><input type="button" value="Elutasítás" id="decline" onclick="document.getElementById('cookie').style.display = 'none';"><input type="hidden" name="filename" value="index.php"><input type="submit" id="accept" value="Engedélyezés"></form>
</div>
<?php
}
?>
<nav id="desktop">
<!--<h1><?php echo $sitename; ?> honlapja</h1>-->
<a id="elso" href="<?php echo $rootdir; ?>index.php">Főoldal</a>
<a href="<?php echo $rootdir; ?>miserend.php">Liturgiák rendje</a>
<a href="<?php echo $rootdir; ?>history.php">Templomunkról</a>
<!--<a href="<?php echo $rootdir; ?>kapolna.php">Kápolnánkról</a>-->
<a href="<?php echo $rootdir; ?>images.php">Képek</a>
<a href="<?php echo $rootdir; ?>blog.php">A fília blogja</a>
<a href="<?php echo $rootdir; ?>usefull.php">Hasznosságok</a>
<?php
if (!isset($_SESSION["userId"]))
{
	?>
    <a href="<?php echo $rootdir; ?>imak.php">Imádságok</a>
    <a href="<?php echo $rootdir; ?>index.php#info">Közérdekű információk</a>
    <a href="<?php echo $rootdir; ?>login.php" id="right-elso" class="right">Bejelentkezés</a>
    <?php
}else {
  ?>
  <a href="<?php echo $rootdir; ?>logout.php" class="right">Kijelentkezés</a>
  <a href="<?php echo $rootdir; ?>create.hirdetes.php" class="right">Hirdetés létrehozása</a>
  <a href="<?php echo $rootdir; ?>form.create.szertartas.php" class="right">Liturgia hozzáadása</a>
  <a href="<?php echo $rootdir; ?>admin.php" class="right" id="right-elso">Adminisztráció</a>
<?php
}
?>
</nav>
<p id="menubutton" onclick="myFunction(this)">Menü</p>
<div id="mobile">
<nav id="mobilenav">
    <ul>
        <li><a id="elso" href="<?php echo $rootdir; ?>index.php">Főoldal</a></li>
        <li><a href="<?php echo $rootdir; ?>miserend.php">Liturgiák rendje</a></li>
        <li><a href="<?php echo $rootdir; ?>history.php">Templomunkról</a></li>
        <li><a href="<?php echo $rootdir; ?>kapolna.php">Kápolnánkról</a></li>
        <li><a href="<?php echo $rootdir; ?>images.php">Képek</a></li>
        <li><a href="<?php echo $rootdir; ?>blog.php">A fília blogja</a></li>
        <li><a href="<?php echo $rootdir; ?>usefull.php">Hasznosságok</a></li>
        <?php
        
        if (!isset($_SESSION["userId"]))
        {
          ?>
            <li><a href="<?php echo $rootdir; ?>imak.php">Imádságok</a></li>
            <li><a href="<?php echo $rootdir; ?>index.php#info">Közérdekű információk</a></li>
            <li><a href="<?php echo $rootdir; ?>login.php" id="right-elso" class="right">Bejelentkezés</a></li>
            <?php
        }else {
          ?>
          <li><a href="<?php echo $rootdir; ?>logout.php" class="right">Kijelentkezés</a></li>
          <li><a href="<?php echo $rootdir; ?>create.hirdetes.php" class="right">Hirdetés létrehozása</a></li>
          <li><a href="<?php echo $rootdir; ?>form.create.szertartas.php" class="right">Liturgia hozzáadása</a></li>
          <li><a href="<?php echo $rootdir; ?>admin.php" class="right" id="right-elso">Adminisztráció</a></li>
        <?php
        }
        ?>
    </ul>
</nav>
</div>
<script>
function myFunction(x) {
  x.classList.toggle("change");
  document.getElementById("mobile").classList.toggle("visible");
  document.getElementById("mobilenav").classList.toggle("visible");
  
}
</script>