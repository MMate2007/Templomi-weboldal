<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php include("head.php"); ?>
<title>Bejelentkezés - <?php echo $sitename; ?></title>
<meta name="title" content="Bejelentkezés - <?php echo $sitename; ?>">
<meta name="description" content="Bejelentkezés után szerkeszteni tudja az oldal bizonyos pontjait. Ha Ön is szeretne segíteni a weboldal jobbá tételében írjon a <?php echo getsetting('main.email'); ?> e-mail címre!">
<meta name="language" content="hu-HU">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
html, body {
    height: 100%;
    min-height: 100%;
    margin: 0;
    padding: 0;
    background-image: url("<?php echo getheadimage(); ?>");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
div.container {
    background-color: rgba(255, 255, 255, 0);
}
</style>
</head>
<body>
    <?php
            $height = "35%";
            $bgimg = getheadimage();
            if (!isset($_COOKIE["enablecookie"])) {
                ?>
                <script>
                    alert("Most olyan oldalt készül megtekinteni, amelynek használatához szükség van a szükséges sütik engedélyezéséhez. Úgy tűnik, hogy Ön ezt nem engedélyezte, ezért az oldal működésében hiba léphet fel, előfordulhat, hogy egyes funkciók nem működhetnek és az oldal nem várt módon viselkedhet.");
                </script>
                <?php
            }
        ?>
        <header style="height: <?php echo $height; ?>;" class="mask">
        <div class="head h-100">
        <div class="fejlecparallax text-center bg-image h-100">
        <?php
        include("navbar.php");
        ?>
        </div>
        </div>
        </div>
        </header>
    <!-- <main class="content"> -->
    <div class="mask" style="height: 65%;">
        <div class="container glass" style="width: max-content; padding: 2.5%;">
            <h1 class="text-white text-center">Bejelentkezés</h1>
        <!-- <p class="text-center">Ha szeretné szerkeszteni a weboldal tartalmát kérem jelentkezzen be az alábbi űrlap segítségével!</p> -->
        <form name="login" action="#" method="post" id="loginform">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" class="form-control" name="username" <?php if (isset($_POST["username"])): ?>value="<?php echo correct($_POST["username"]); ?>"<?php endif ?> required placeholder="Felhasználónév">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                        <input type="password" name="pass" id="pass" class="form-control" required placeholder="Jelszó">
                    </div>
                    <div class="input-group justify-content-center"><button type="submit" class="btn btn-primary text-white btn-block"><i class="bi bi-box-arrow-in-right"></i> Bejelentkezés</button></div>
                </div>
            </div>
        </form>
        </div>
        <!-- </main> -->
        <?php
        if (isset($_POST["username"]) && isset($_POST["pass"]))
        {
            //TODO check() függvén beépítése a bemenet ellenőrzésére
            if (isset($_POST["message"])) {
                displaymessage("danger", $_POST["message"]);
            }
            $username = correct($_POST["username"]);
            $pass = $_POST["pass"];
            $usernamevalid = false;
            $sql = "SELECT * FROM `author` WHERE `username` = '".$username."'";
            $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
            while ($row = mysqli_fetch_array($eredmeny))
            {
                $usernamevalid = true;
                $pass2 = $row["password"];
                $id = $row["id"];
                $name = $row["name"];
                $egyhsz = $row["egyhaziszint"];
                $twofa = $row["2fasecret"];
                if (password_verify($pass, $pass2))
                {
                    session_regenerate_id();
                    if ($hashtransition == true && password_needs_rehash($pass2, $pwdhashalgo)) {
                        $newpass = password_hash($pass, $pwdhashalgo);
                        $sqlb = "UPDATE `author` SET `password`='$newpass' WHERE `id` = '$id'";
                        $eredmenyb = mysqli_query($mysql, $sqlb) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                    }
                    if ($twofa == null) {
                    if (checkpermission("bejelentkezes", $id))
                    {

                            $_SESSION["uid"] = $id;
                            $session = new Session();
                            if ($session->validonlogin()) {
                                $_SESSION["userId"] = $id;
                                $_SESSION["name"] = $name;
                                // $_SESSION["szint"] = $admin;
                                $_SESSION["egyhszint"] = $egyhsz;
                                $session->login();
                                header("Location: admin.php");
                                exit();
                            } else {
                                unset($session);
                                displaymessage("danger", "Hiba bejelentkezés közben. Kérem próbálja újra!");
                            }
                        } else {
                            displaymessage("warning", "Ön nem jelentkezhet be, mert fiókját ideiglenesen letiltották!");
                        }
                    } else {
                        $_SESSION["uid"] = $id;
                        header("Location: 2fa.php");
                    }
                } else if ($hashtransition == true && sha1(md5($pass)) == $pass2) {
                    $newpass = password_hash($pass, $pwdhashalgo);
                    $sqlb = "UPDATE `author` SET `password`='$newpass' WHERE `id` = '$id'";
                    $eredmenyb = mysqli_query($mysql, $sqlb) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
                    displaymessage("info", "Kérem próbálja újra!"); }
                else{
                    formvalidation("input[name=username]", true);
                    formvalidation("input[name=pass]", false, "Helytelen jelszó!");
                    ?>
                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                    <?php
                }
            }
            if ($usernamevalid == false)
            {
                formvalidation("input[name=username]", false, "Helytelen felhasználónév!");
            }
        }
        if (isset($_SESSION["userId"]))
        {
            header("Location: admin.php");
        }
        ?>
    </div>
<!-- <?php //include("footer.php"); ?> -->
</body>
</html>