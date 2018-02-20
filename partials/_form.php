<form method='POST' action='index.php'>
    
    <div class='form-group row'>
        <div class="col-sm-2">
            <label for='text' class='col-form-label'>
                Text to Translate
            </label>
            <div class='small red'>* Required</div>
            </div>
        </label>
        <div class='col-sm-10'>
            <textarea name='text' cols='15' rows='10' class='form-control'><?= $form->prefill('text') ?></textarea>
        </div>
    </div>
    
    <div class='form-group row'>
        <div class='col-sm-2 col-form-label'>
            <label for='suffix'>Suffix</label>
        </div>
        <div class='col-sm-10'>
            <input type='radio' name='suffix' value='ay' <?= ($suffix == 'ay' || !isset($suffix)) ? 'checked' : ''?>> "ay"
            <input type='radio' name='suffix' value='a' <?= ($suffix == 'a') ? 'checked' : ''?>> "a"
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-2'>
            Rules
        </div>
        <div class='col-sm-10'>
            <p>
                Words that begin with a single consonant 
                shift the first letter to the end and 
                append suffix.
                Example: <em>hello => ellohay</em>
            </p>
            <p>
                Words that begin with two consecutive consonants shift
                the cluster to the end and append suffix.
                Example: <em>cheers => eerschay</em>
            </p>
            <p>
                Words that begin with a vowel add <em>way</em> to the end.
                Example: <em>eat => eatway</em>
            </p>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-sm-2 col-form-label'>
            <label for='short'>Optional Rules</label>
        </div>
        <div class='col-sm-10'>
            <input type='checkbox' name='short' <?= $short ? 'checked' : '' ?>>
            Words that are shorter than three characters are left as is. 
            Example: <em>an => an</em>
        </div>
    </div>
    
    <div class='form-group row'>
        <div class='col-sm-2'>
            <button type='submit' name='submit' class='btn btn-primary'>Translate</button>
        </div>
        <?php if ($translated) : ?>
            <div class='col-sm-10'>
                <div class='translated alert alert-success'>
                    <?= $translated ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</form>