<form method="POST" action="index.php">
    <div class="form-group">
        <label for="text">Text to Translate</label>
        <textarea name="text" cols="15" rows="10" class='form-control'>
        </textarea>
    </div>
    
    <label for="suffix">
        Suffix
        <input type="radio" name="suffix" value="ay" checked> "ay"
        <input type="radio" name="suffix" value="a"> "a"
    </label>
    
    <label for="short">
        Optional Rules
        <input type="checkbox" name="short">
    </label>
    
    <input type="submit" name="submit">
</foirm>