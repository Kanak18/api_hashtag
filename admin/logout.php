<?php include '../includes/connection.php'; ?>
<?php
session_destroy();
header("Location:" . ROOT_SITE_URL . "admin");
?>
