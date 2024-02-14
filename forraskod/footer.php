<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top bg-black text-white" style="margin-bottom: 0px;">
    <div>
        <!-- TODO jól megcsinálni a láblécet -->
        <?php
        $copyright = getcontent("copyright");
        if ($copyright != null) {
            ?>
            <p><?php echo $copyright; ?></p>
            <?php
        }
        $address = getcontent("address");
        if ($address != null) {
            ?>
            Levélcím: <address><?php echo $address; ?></address>
            <?php
        }
        $email = getsetting("main.email");
        if ($email != null) {
            ?>
            <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
            <?php
        }
        ?>
    </div>
    <div>
        <!-- TODO ide jön a fő navigáció -->
    </div>
</footer>
<?php
mysqli_close($mysql);
?>