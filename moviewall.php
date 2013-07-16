<?php
$starting_time_measure = MICROTIME(TRUE);
require_once 'class/database.php';
require_once 'class/Login.php';
$db = new Database();

$login = new Login($db);

if($login ->isUserLoggedIn() == false) {
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
		<link href="css/bootstrap-responsive.css" rel="stylesheet" />
	</head>
	<body>
		<div class="login">
			Du är inte inloggad! Gå till <a href="index.php">Startsidan</a> för att logga in.
		</div>
	</body>
</html>
<?php
break;
}

require_once 'class/arraytools.php';

if (!empty($_REQUEST['p']) && is_numeric($_REQUEST['p'])) {
	$page = filter_var($_REQUEST['p'], FILTER_SANITIZE_NUMBER_INT);
} else {
	$page = 1;
}

$numberofimgperside = 9;

$ar = new ArrayTools();

$sql = "SELECT id, title, poster
		FROM movies
		ORDER BY id DESC";

$movie = $db -> select_query($sql, array(), $numberofimgperside, $page);

$sql = "SELECT count(id)
		FROM movies
		ORDER BY id DESC";

$numberofmovies = $ar -> unique_flat_array($db -> select_query($sql));
$numberofmovies = $numberofmovies[0];

if ($page < 10) {
	$lover = 1;
	$upper = 12;
} elseif ($page > $numberofmovies / $numberofimgperside - 9) {
	$lover = $numberofmovies / $numberofimgperside - 12;
	$upper = $numberofmovies / $numberofimgperside;
} else {
	$lover = $page - 9;
	$upper = $page + 9;
}

$sitetitle = "Filmvägg";
require_once 'template/header.php';
?>
<div class="hero-unit">
	<div class="row-fluid no-space">
		<div class="span4">
			<?php
			$i = 0;
			while ($i < $numberofimgperside) {
				echo '<a href="dispmovie.php?id=' . $movie[$i]["id"] . '"><img src="img/posters/' . $movie[$i]["poster"] . '" title="' . $movie[$i]["title"] . '" width="100%" /></a>';
				$i += 3;
			}
			?>
		</div>
		<div class="span4">
			<?php
			$i = 1;
			while ($i < $numberofimgperside) {
				echo '<a href="dispmovie.php?id=' . $movie[$i]["id"] . '"><img src="img/posters/' . $movie[$i]["poster"] . '" title="' . $movie[$i]["title"] . '" width="100%" /></a>';
				$i += 3;
			}
			?>
		</div>
		<div class="span4">
			<?php
			$i = 2;
			while ($i < $numberofimgperside) {
				echo '<a href="dispmovie.php?id=' . $movie[$i]["id"] . '"><img src="img/posters/' . $movie[$i]["poster"] . '" title="' . $movie[$i]["title"] . '" width="100%" /></a>';
				$i += 3;
			}
			?>
		</div>
	</div>
	<div class="pagination pagination-centered">
		<ul>
			<?php
			for ($i = $lover; $i <= $upper; $i++) {
				echo '<li';
				if ($page == $i){
					echo  ' class="active" ';
				}
				echo '>';
				echo '<a href="moviewall.php?p='.$i.'">' . $i . '</a>';
				echo '</li>';
			}
			?>
		</ul>
	</div>
</div>
<?php
require_once 'template/footer.php';