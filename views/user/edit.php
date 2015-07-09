<h1>Edit User</h1>
<form action="<?php echo BASE_PATH; ?>user/editSave/<?php echo $this->user['id']; ?>" method="post">
    <label>Login</label><input type="login" name="login" value="<?php echo $this->user['login']; ?>" /><br />
    <label>Password</label><input type="password" name="password" /><br />
    <label>Role</label>
    <select name="role">
        <option value="default" <?php if ($this->user['role'] == 'default') { echo 'selected'; } ?>>Default</option>
        <option value="admin" <?php if ($this->user['role'] == 'admin') { echo 'selected'; } ?>>Admin</option>
    </select><br />
    <label>&nbsp;</label><input type="submit" />
</form>