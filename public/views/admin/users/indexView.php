<table class="table">
    <tr>
        <th>#</th>
        <th>firstname</th>
        <th>lastname</th>
        <th>age</th>
        <th>Action</th>
    </tr>
    <a class="btn btn-lg btn-info" href="/users/add" >Add</a>
    <?php foreach ($data['data'] as $item): ?>
        <tr>
            <td><a href="/users/show/<?= $item['id']; ?>">#<?= $item['id']; ?></a></td>
            <td><a href="/users/show/<?= $item['firstname']; ?>"><?= $item['firstname']; ?></a></td>
            <td><a href="/users/show/<?= $item['lastname']; ?>"><?= $item['lastname']; ?></a></td>
            <td><a href="/users/show/<?= $item['age']; ?>"><?= $item['age']; ?></a></td>
            <td>
                <form method="POST" action="/users/delete">
                    <input type="hidden" name="id" value="<?= $item['id']; ?>"/>
                    <input class="btn btn-lg btn-danger" type="submit" value="Remove"/>
                </form>
                <a class="btn btn-lg btn-info" href="/users/update/<?= $item['id']; ?>" >Update</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $pagination->getPaginationHtml() ?>