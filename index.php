<?php

?>
<!DOCTYPE html>
<html>
    <?php include 'partials/_head.php' ?>
   <body>
        <div class="container">

            <?php include 'partials/_description.php' ?>
            
            <form method="POST" action="put-php-file-here">
                {# textarea #}
                <textarea name="text">

                {# suffix #}
                <input type="radio" name="suffix">

                {# optional rules #}
                <input type="checkbox" name="short">

                {# submit button #}
                <input type="submit" name="submit">
        </div>
   </body>
</html>