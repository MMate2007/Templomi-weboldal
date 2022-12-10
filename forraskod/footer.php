<div class="footer">
<hr>
<footer>
<p><?php echo $sitename; ?> honlapja</p>
<p><a href="mailto:<?php echo getsetting($mysql, 'main.email'); ?>"><?php echo getsetting($mysql, 'main.email'); ?></a></p>
</footer>
</div>
<?php
mysqli_close($mysql);
?>