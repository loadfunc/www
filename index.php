<?php
// curl https://apisql.github.io/php/api_sql.php --output api_sql.php
include 'api_sql.php';
?>

<table class="table table-bordered">
    <thead class="alert-info">
    <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Address</th>
    </tr>
    </thead>
    <tbody style="background-color:#fff;">
    <?php
    api_sql('sqlite:db.sqlite3', "SELECT * FROM `member` ORDER BY `lastname` ASC", function ($fetch) {
        ?>
        <tr>
            <td><?php echo $fetch['firstname'] ?></td>
            <td><?php echo $fetch['lastname'] ?></td>
            <td><?php echo $fetch['address'] ?></td>
        </tr>
        <?php
    });
    ?>

    </tbody>
</table>
