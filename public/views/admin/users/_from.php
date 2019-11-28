
<form method="POST" action="/users/create">
  <?php
    echo $form->inputHidden('id','id form');
    echo $form->input('firstname','firstname form');
    echo $form->input('lastname','lastname form');
    echo $form->input('age','age form');
  ?>
  <button type="submit" class="btn btn-primary">Save</button>
</form>