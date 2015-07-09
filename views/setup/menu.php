<?php
$page = explode('/', $_SERVER['REQUEST_URI']);
array_shift($page);

$page = $page[1];
$active = "active";
$no_active = "disabled hidden-xs";
?>
<ul id="account_setup" class="nav nav-tabs nav-justified" role="tablist">
    <li class="<?php echo ($page == 'password') ? $active : $no_active; ?>"><a  href="#password" role="tab" <?php // echo ($page == 'password') ? "data-toggle='tab'" : ""; ?> >New password</a></li>
    <li class="<?php echo ($page == 'details') ? $active : $no_active; ?>"><a href="#details" role="tab">Personal details</a></li>
    <li class="<?php echo ($page == 'bank') ? $active : $no_active; ?>"><a href="#bank" role="tab">Bank account</a></li>
    <li class="<?php echo ($page == 'beneficiary') ? $active : $no_active; ?>"><a href="#beneficiary" role="tab">Beneficiary's details</a></li>
    <li class="<?php echo ($page == 'payment') ? $active : $no_active; ?>"><a href="#payment" role="tab">Payment details</a></li>
</ul>