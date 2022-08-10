<?php
/*
Version: 1.0.0
Author: eartahhj - https://www.codinghouse.it/ - https://www.gaminghouse.community
Donate: https://liberapay.com/GamingHouse/donate
*/

ini_set('display_errors', 'on');
error_reporting(E_ALL);

setlocale(LC_ALL, 'en_US');
bindtextdomain("phpGoogleCSE", './locale');
textdomain("phpGoogleCSE");

use \CodingHouse\GoogleCSE\GoogleCustomSearchEngine;

# Insert your search engine ID here, get it from https://programmablesearchengine.google.com/
$searchEngineId = '';

# Insert your API key here, get it from https://cloud.google.com/
$searchEngineApiKey = '';

$customContainerCssClass = '';
$customFormId = '';
$customFormCssClass = '';
$customActionUri = $_SERVER['PHP_SELF'];
$googleCSE = null;
$language = 'en';

require_once 'CodingHouse/GoogleCSE/GoogleCustomSearchEngine.php';

if ($searchEngineApiKey) {
	try {
		$googleCSE = new \CodingHouse\GoogleCSE\GoogleCustomSearchEngine($searchEngineId, $searchEngineApiKey, $language);
		$googleCSE->initEngine();
	} catch (\Exception $e) {
		echo $e->getMessage();
	}
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Search with Google CSE - PHP Google CSE Standalone</title>
		<link rel="preload" href="assets/css/cse.css" as="style">
		<link rel="preload" href="assets/js/cse.js" as="script">
		<link rel="stylesheet" href="assets/css/cse.css">
		<script type="text/javascript" src="assets/js/cse.js"></script>
	</head>
	<body>
		<main id="primary" class="site-main">
			<div class="googlecse-container<?=($customContainerCssClass ? ' ' . $customContainerCssClass : '')?>">
				<?php if ($googleCSE):?>
					<?php $googleCSE->renderForm($customFormId, $customFormCssClass, $customActionUri)?>

					<div class="search-results">
				    <?php
					$googleCSE->html();
				    $googleCSE->renderPromoResults();
				    $googleCSE->renderNormalResults();
				    $googleCSE->renderPager();
				    ?>
				    </div>
				<?php else:?>
					<script async src="https://cse.google.com/cse.js?cx=<?=htmlspecialchars($searchEngineId)?>"></script>
				    <div class="gcse-search"></div>
				<?php endif?>
				<p>
					Made by <a href="https://github.com/eartahhj" rel="noopener external" target="_blank">eartahhj</a> @ <a href="https://www.codinghouse.it" rel="noopener external" target="_blank">CodingHouse</a> - See <a href="https://github.com/eartahhj" rel="noopener external" target="_blank">docs</a>
				</p>
			</div>
		</main>
	</body>
</html>
