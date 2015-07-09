<h1>User</h1>

<form action="<?php echo BASE_PATH; ?>user/create" method="post">
    <label>Login</label><input type="login" name="login" /><br />
    <label>Password</label><input type="password" name="password" /><br />
    <label>Role</label>
    <select name="role">
        <option value="default">Default</option>
        <option value="admin">Admin</option>
    </select><br />
    <label>&nbsp;</label><input type="submit" />
</form>
<hr>
<table cellpadding="3" cellspacing="3" border="0">
    <?php
    foreach ($this->userList as $key => $value) {

        $editLink = '<a href="' . BASE_PATH . 'user/edit/' . $value['id'] . '">Edit</a>';
        $deleteLink = '<a href="' . BASE_PATH . 'user/delete/' . $value['id'] . '">Delete</a>';

        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['login'] . '</td>';
        echo '<td>' . $value['role'] . '</td>';
        echo '<td>' . $editLink . ' ' . $deleteLink . '</td>';
        echo '</tr>';
    }
    ?>
</table>