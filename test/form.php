<?php
require '../libs/form.php';
require '../libs/val.php';


if (isset($_REQUEST['run'])) {
    try {
        $form = new form();

        $form->post('name')
                ->val('minlength', 4)
                ->post('age')
                ->val('digit')
                ->post('gender');
        $form->submit();
        
        $data = $form->fetch();
        
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>

<form method="POST" action="?run">
    <label>Name :</label><input type="text" name="name" />
    <label>Age :</label><input type="text" name="age" />
    <label>Gender :</label>
    <select name="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>
    <input type="submit" value="Submit" />
</form>