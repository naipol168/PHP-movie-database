<?php
$sql = "SELECT news.description, news.date, users.name FROM `news`
		JOIN users ON news.userid = users.id
		ORDER BY news.id DESC";

$result = $db -> select_query($sql, array(), 10, 1);

$sitetitle = "Nyheter";
require_once ('template/header.php');
?>
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span9">
			<h5> Nyheter! </h5>
			<?php
			foreach ($result as $value) {
				echo "<p><strong>" . $value['name'] . "</strong>, " . $value['date'] . "</p><p>";
				echo nl2br($value['description']);
				echo "</p>";
			}
			?>
		</div>
		<div class="span3">
			<h4>L&auml;gg till nyhet</h4>
			<form name = "input" action = "addnews.php" method = "post">
				<textarea name="description" rows="10" placeholder="Vad har gjorts?"></textarea>
				<input name="userid" type="hidden" value="<?php echo $_SESSION['user_id'];?>" />
				<br />
				<input type="submit" value="submit" class="btn btn-primary" />
			</form>
		</div>
	</div>
</div>
<?php
require_once ('template/footer.php');