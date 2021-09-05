<nav id="desktop">
<a id="elso" href="http://www.fabianistva.nhely.hu/index.php">Főoldal</a>
<a href="http://www.fabianistva.nhely.hu/miserend.php">Liturgiák rendje</a>
<a href="http://www.fabianistva.nhely.hu/history.php">Templomunkról</a>
<a href="http://www.fabianistva.nhely.hu/kapolna.php">Kápolnánkról</a>
<a href="http://www.fabianistva.nhely.hu/images.php">Képek</a>
<a href="http://www.fabianistva.nhely.hu/blog.php">A fília blogja</a>
<a href="http://www.fabianistva.nhely.hu/usefull.php">Hasznosságok</a>
<?php
session_start();
if (!isset($_SESSION["userId"]))
{
	?>
    <a href="http://www.fabianistva.nhely.hu/imak.php">Imádságok</a>
    <a href="http://www.fabianistva.nhely.hu/index.php#info">Közérdekű információk</a>
    <?php
}
?>
<a href="http://www.fabianistva.nhely.hu/login.form.php" id="right-elso" class="right">Bejelentkezés</a>
</nav>
<div class="container" onclick="myFunction(this)">
  <div class="bar1"></div>
  <div class="bar2"></div>
  <div class="bar3"></div>
</div>
<div id="mobile">
<nav id="mobilenav">
    <ul>
        <li><a id="elso" href="http://www.fabianistva.nhely.hu/index.php">Főoldal</a></li>
        <li><a href="http://www.fabianistva.nhely.hu/miserend.php">Liturgiák rendje</a></li>
        <li><a href="http://www.fabianistva.nhely.hu/history.php">Templomunkról</a></li>
        <li><a href="http://www.fabianistva.nhely.hu/kapolna.php">Kápolnánkról</a></li>
        <li><a href="http://www.fabianistva.nhely.hu/images.php">Képek</a></li>
        <li><a href="http://www.fabianistva.nhely.hu/blog.php">A fília blogja</a></li>
        <li><a href="http://www.fabianistva.nhely.hu/usefull.php">Hasznosságok</a></li>
        <?php
        session_start();
        if (!isset($_SESSION["userId"]))
        {
            ?>
            <li><a href="http://www.fabianistva.nhely.hu/imak.php">Imádságok</a></li>
            <li><a href="http://www.fabianistva.nhely.hu/index.php#info">Közérdekű információk</a></li>
            <?php
        }
        ?>
        <li><a href="http://www.fabianistva.nhely.hu/login.form.php" id="right-elso" class="right">Bejelentkezés</a></li>
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