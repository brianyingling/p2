<form method="POST" action="index.php">
    <label for="text">
        Text to translate
        <textarea name="text">
            <?php $form->prefill("text") ?>
        </textarea>
    </label>
    
    <label for="suffix">
        Suffix
        <input type="radio" name="suffix" value="ay"> "ay"
        <input type="radio" name="suffix" value="a"> "a"
    </label>
    
    <label for="short">
        Optional Rules
        <input type="checkbox" name="short">
    </label>
    
    <input type="submit" name="submit">
</foirm>