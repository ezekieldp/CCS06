<?php
include 'header.php';
?>

<h1>My Home Page</h1>

<?php
if (isset($_SESSION['email'])) {
    echo "<h2>Welcome " . $_SESSION['name'] . ". Your email id is " . $_SESSION['email'] . "</h2>";

?>

<h3><a href="logout.php">Log out</a3></h3>

<?php }
else {
?>
<h3>Click <a href="login.php">here</a> to log in.</h3>
<?php } ?>
</body>
</html>