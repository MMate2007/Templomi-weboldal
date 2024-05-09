<?php
//TODO funkció hozzáadása: PDF generálása a szertartásokból (ld. ajkai plébániai hirdetések)
// TODO lehessen engedélyezni, hogy a különböző dátumokat UTC-ben mentsük és mindig a kliens órájának megfelelően mutassuk
include("config.php"); 
include("functions.php");
if (isset($_COOKIE['enablecookie'])) { session_start(); }
?>
<script>
    var html = document.querySelector("html");
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        html.setAttribute("data-bs-theme", "dark");
    } else {
        html.setAttribute("data-bs-theme", "light");
    }
    var msgdivek = [];
</script>
<meta charset="utf-8">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Bootstarp-->
<link rel="stylesheet" href="css/customise.min.css">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/customstyle.css">
<link rel="icon" type="image/pnp" href="icon.png">
<?php 
if ($themecolor != null)
{
    ?>
    <meta name="theme-color" content="<?php echo $themecolor; ?>">
    <?php
}
$mysql = mysqli_connect($mysqlhost, $mysqlu, $mysqlp, $mysqld) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
mysqli_query($mysql, "SET NAMES utf8");
//Webhelyadatok betöltése
$sitename = getsetting("main.name");
deletepastszertartas();
if (getsetting("logvisits")) {
newvisit(basename($_SERVER['REQUEST_URI'])); }
?>