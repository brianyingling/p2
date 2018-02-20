<?php if ($form->hasErrors) : ?>
    <div class='alert alert-danger'>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>