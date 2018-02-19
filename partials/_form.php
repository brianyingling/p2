<form method="POST" action="index.php">
    
    <div class="form-group row">
        <label for="text" class="col-sm-2 col-form-label">Text to Translate</label>
        <div class="col-sm-10">
            <textarea name="text" cols="15" rows="10" class='form-control'><?= $form->prefill('text') ?></textarea>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-2 col-form-label">
            <label for="suffix">Suffix</label>
        </div>
        <div class="col-sm-10">
            <input type="radio" name="suffix" value="ay" <?= ($suffix == 'ay' || !isset($suffix)) ? 'checked' : ''?>> "ay"
            <input type="radio" name="suffix" value="a" <?= ($suffix == 'a') ? 'checked' : ''?>> "a"
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2 col-form-label">
            <label for="short">Optional Rules</label>
        </div>
        <div class="col-sm-10">
            <input type="checkbox" name="short" <?= $short ? 'checked' : '' ?>>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-2">
            <button type="submit" name="submit" class='btn btn-primary'>Translate</button>
        </div>
        <?php if ($translated) : ?>
            <div class="col-sm-10">
                <div class="translated alert alert-success">
                    <?= $translated ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</form>