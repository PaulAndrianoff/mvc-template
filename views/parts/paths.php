<ul>
    <?php foreach ($_SESSION['previous_url'] as $key => $value): ?>

        <?php 
            $parseValue = str_replace('/' . BASE_URL, '', $value);
        ?>

        <li><a href="<?= $value ?>"><?= $parseValue ?></a></li>
    <?php endforeach ?>
</ul>