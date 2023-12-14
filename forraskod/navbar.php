<nav id="desktop" class="navbar navbar-expand-lg navbar-dark fixed-top">
  <script>
    var navbarbgstate = 0;
    var navbar = document.querySelector('.navbar');
  </script>
<div class="container-fluid">
  <a href="#" class="navbar-brand"><?php echo $sitename; ?></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" onclick="
  if (navbarbgstate == 0) {
  navbar.classList.add('bg-black');
  navbarbgstate = 1;
  } else {
    navbar.classList.remove('bg-black');
  navbarbgstate = 0;
  }
  "><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="nav">
    <ul class="navbar-nav">
      <?php
      $sql = "SELECT `id`, `url`, `name`, `tooltip`, `newtab` FROM `nav` WHERE `navid` = 'desktop' and `parentid` is null ORDER BY `sorszam`";
      $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
      while ($row = mysqli_fetch_array($eredmeny))
      {
        $url = $row["url"];
        $name = $row["name"];
        $tp = $row["tooltip"];
        $id = $row["id"];
        $newtab = $row["newtab"];
        $haschildren = null;
        $sqlp = "SELECT `url`, `name`, `tooltip`, `newtab` FROM `nav` WHERE `navid` = 'desktop' and `parentid` = '$id' ORDER BY `sorszam`";
        $eredmenyp = mysqli_query($mysql, $sqlp) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
        if (mysqli_num_rows($eredmenyp) > 0) {
          $haschildren = true;
        }
        //TODO többszörös dropdown lehetővé tétele
        ?>
        <li class="nav-item <?php if ($haschildren == true) { echo 'dropdown'; } ?>">
          <a href="<?php echo $url; ?>" class="nav-link <?php if ($haschildren == true) { echo 'dropdown-toggle'; } ?>" title="<?php echo $tp; ?>"  <?php if ($haschildren == true) { echo "id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'"; } if ($newtab == 1) { echo "target='_blank'"; }?>><?php echo $name; ?></a>
          <?php
            if($haschildren == true) {
              ?>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php
                while ($rowp = mysqli_fetch_array($eredmenyp)) {
                  if ($rowp["name"] == "dropdown-divider" && $rowp["url"] == "dropdown-divider" && $rowp["tooltip"] == "dropdown-divider") {
                    ?>
                    <li><hr class="dropdown-divider"></li>
                    <?php
                  } else {
                  ?>
                  <li><a class="dropdown-item" href="<?php echo $rowp['url']; ?>" <?php if ($rowp['tooltip'] != null) { ?>title="<?php echo $rowp['tooltip']; ?>" <?php } if ($rowp["newtab"] == 1) { echo "target='_blank'"; } ?>><?php echo $rowp["name"];; ?></a></li>
                  <?php
                  }
                }
                ?>
              </ul>
              <?php
            }
          ?>
        </li>
        <?php
      }
      ?>
    </ul>
    <ul class="navbar-nav ms-auto">
      <?php
      if (!isset($_SESSION["userId"]))
      {
        ?>
            <li class="nav-item"><a class="nav-link" href="login.php" id="right-elso" class="right"><i class="bi bi-box-arrow-in-right"></i> Bejelentkezés</a></li>
          <?php
      }else {
        ?>
        <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="admin.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           <i class="bi bi-person-fill"></i> <?php echo $_SESSION["name"]; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="admin.php"><i class="bi bi-person-circle"></i> Profil</a></li>
            <?php
              $sql = "SELECT `id`, `url`, `name`, `tooltip` FROM `nav` WHERE `navid` = 'quickadmin' and `parentid` is null ORDER BY `sorszam`";
              $eredmeny = mysqli_query($mysql, $sql) or die ("<p class='warning'>A következő hiba lépett fel a MySQL-ben: ".mysqli_error($mysql)."</p>");
              if (mysqli_num_rows($eredmeny) > 0) {
                ?>
                <li><hr class="dropdown-divider"></li>
                <?php
              }
              while ($row = mysqli_fetch_array($eredmeny))
              {
                $url = $row["url"];
                $name = $row["name"];
                $tp = $row["tooltip"];
                $id = $row["id"];
                //TODO többszörös dropdown lehetővé tétele
                if ($row["name"] == "dropdown-divider" && $row["url"] == "dropdown-divider" && $row["tooltip"] == "dropdown-divider") {
                  ?>
                  <li><hr class="dropdown-divider"></li>
                  <?php
                } else {
                ?>
                <li>
                  <a href="<?php echo $url; ?>" class="dropdown-item" title="<?php echo $tp; ?>"><?php echo $name; ?></a>
                </li>
                <?php
                }
              }
            ?>
            <li><hr class="dropdown-divider"></li>
            <?php if (checkpermission("addliturgia")) { ?><li><a href="create.szertartas.php" class="dropdown-item">Liturgia hozzáadása</a></li><?php } ?>
            <?php if (checkpermission("removeliturgia")) { ?><li><a href="miserend.hu" class="dropdown-item">Liturgia törlése</a></li> <?php } ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Kijelentkezés</a></li>
          </ul>
        </li>
        <?php
    }
    ?>
    </ul>
  </div>
</div>
</nav>

<?php if(!isset($_COOKIE['enablecookie'])) { ?>
    <script>
      function declinecookies() {
        document.getElementById('cookie').style.display = 'none';
      }
    </script>
    <div id="cookie" class="fixed-bottom" style="background-color: rgba(255,255,255,0.7); padding: 20px;">
      <p>Ez a webhely sütiket (HTTP Cookies) használ bizonyos funkciókhoz. Ha többet szeretne megtudni, hogy mit tárolnak az adott sütik mutasson rá (helyezze fölé a kurzort) a csoportra. Ha elutasítja a sütiket, akkor bizonyos funkciók nem fognak működni.</p>
      <form action="cookie.php" method="get" id="cookieform">
        <input type="checkbox" name="mandatorycookies" id="mandatorycookies" value="1" class="form-check-input" checked disabled>
        <label for="mandatorycookies" class="form-check-label text-black" title="Ezek a sütik kellenek például ahhoz, hogy működjön a bejelentkezés, emlékezzen a program, hogy mely sütiket engedélyeztük.">Szükséges sütik</label>
        <input type="checkbox" name="conventionalcookies" id="conventionalcookies" value="1" class="form-check-input">
        <label for="conventionalcookies" class="form-check-label text-black" title="Ezek a sütik kellenek ahhoz, hogy működjenek az olyan funckiók, amelyek automatikusan kitöltenek űrlapmezőket. Például, hogy kétlépcsős azonosításnál ne kérje újra az adott számítógépen a kódot.">Kényelmi sütik</label>
        <br>
        <input type="button" class="btn btn-danger" value="Összes elutasítása" id="decline" stlye="margin-right: 5px;" onclick="declinecookies();">
        <input type="hidden" name="filename" value="index.php">
        <input type="submit" id="accept" class="btn btn-success" value="Kiválasztottak engedélyezés">
      </form>
    </div>
    <?php
  }
?>
<script>
var header = document.querySelector('.fejlecparallax');
  window.addEventListener('scroll', () => {
    if (window.scrollY > header.offsetHeight - 50) {
      navbar.classList.add('bg-black');
    } else {
      navbar.classList.remove('bg-black');
    }
  });
  var pathname = window.location.pathname;
  pathname = pathname.slice(1);
  var query = "[href='";
  query += pathname;
  query += "']";
  // document.querySelector(query).classList.add("active");
  document.querySelectorAll(query).forEach((a) => { a.classList.add("active"); });
</script>