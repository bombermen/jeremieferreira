<?php
$content = '';
if(isset($_POST['input'])) {
    $content = Utils::parseWiki($_POST['input']);
}
?>

<div id="main_page" class="page">
    <form method="POST" action="#">
        <label for="input">Wiki a convertir</label>
        <textarea id="input" name="input"></textarea>
        <input type="submit" />
    </form>
</div>

<div class="page">
    <?php echo $content; ?>
</div>

<div class="page">
    <?php echo htmlentities($content); ?>
</div>