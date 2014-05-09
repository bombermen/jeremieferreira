<!-- warning
Following php vars must be set:
    $categories
    $states
    $publications
-->

<div id="main_page" class="page">
    <h1>Ajouter une publication</h1>
    <form id="addModifyPublicationForm" method="POST" action="<?php echo SITE_BASE . PREVIEW; ?>">

        <!-- title -->
        <label for="title">Titre</label><input id="title" name="title" type="text" /><br/>

        <!-- categories -->
        <label for="category">Catégorie</label>
        <select id="category" name="category">
            <?php
            foreach ($categories as $category) {
                echo '<option value="' . $category->getId() . '">' . $category->getName() . '</option>';
            }
            ?>
        </select>
        <br/>

        <!-- state -->
        <label for="state">Etat</label>
        <select id="state" name="state">
            <?php
            foreach ($states as $state) {
                echo '<option value="' . $state->getId() . '">' . $state->getName() . '</option>';
            }
            ?>
        </select>
        <br/>

        <!-- parent -->
        <label for="parent">Parent</label>
        <select id="parent" name="parent">
            <option value="0">None</option>
            <?php
            foreach ($publications as $publication) {
                echo '<option value="' . $publication->getId() . '">' . $publication->getTitle() . '</option>';
            }
            ?>
        </select>
        <br/>

        <label for="shortDesc">Description</label><textarea id="shortDesc" name="shortDesc"></textarea><br/>
        <label for="publicationContent">Contenu</label><textarea id="publicationContent" name="publicationContent"></textarea><br/>
        <label for="sources">Sources</label><input id="sources" name="sources" type="text" /><br/>

        <!-- action : add/modify -->
        <input type="hidden" name="action" value="<?php echo $action ?>">

        <label for="submit">&nbsp;</label><input id="submit" type="submit" value="Prévisualiser" />
    </form>
</div>
