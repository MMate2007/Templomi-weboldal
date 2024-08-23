<footer class="footer mt-auto py-3 bg-black">
    <div>
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
</footer>
<?php
mysqli_close($mysql);
?>