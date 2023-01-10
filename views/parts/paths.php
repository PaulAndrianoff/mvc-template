<ul class="arriane-path">
    <?php foreach ($_SESSION['previous_url'] as $key => $value): ?>
        <?php 
            $parseValue = 0 === $key ? 'home' : str_replace('/' . BASE_URL, '', $value);
        ?>
        <li class="arriane-path--item"><a href="<?= $value ?>"><?= $parseValue ?></a></li>
    <?php endforeach ?>
</ul>