<?php
    if(count($errors)>0){
        foreach ($errors['type'] as $error){
            echo <<<EOL
    <div class="alert alert-danger" role="alert">
      $error
    </div>
EOL;
        }
    }

    require_once '_from.php';

    ?>

