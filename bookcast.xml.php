<?php
// 📚🔈 BookCasts
// See: https://github.com/elwinschmitz/bookcasts
//

//
// Configure Options:
//
define('META_DATA_FILE_NAME', 'metadata{.ini,}');
define('COVER_ART_FILE_NAME', 'coverart.{jpg,jpeg,png}');
define('AUDIO_FILE_TYPES', '*.mp3');

//
// Setup data:
//
$metaData = getMetaData();

$channel = [
	'title' => getFolderTitle(),
	'pubDate' => getPubDate(),
	'link' => (!empty($metaData['link'])) ? $metaData['link'] : getBaseUrl(),
	'self' => getSelfUrl(),
	'language' => $metaData['language'],
	'copyright' => $metaData['copyright'],
	'image' => getCoverArt(),
	'description' => $metaData['description'],
	'items' => getItems(),
];

//
// Functions:
//
function getMetaData() {
	$defaults = [
		'language' => 'en',
		'copyright' => '',
		'description' => '',
		'link' => '',
	];
	$metaFiles = glob(META_DATA_FILE_NAME, GLOB_BRACE);

	if (!$metaFiles || count($metaFiles) < 1) {
		return $defaults;
	}

	$customData = parse_ini_file($metaFiles[0]);

	if (!$customData) {
		return $defaults;
	}

	return array_merge($defaults, $customData);
}

function getFolderTitle() {
	return getReadableTitle(basename(__DIR__));
}

function getPubDate($file = null) {
	$fromFile = $file ? $file : __DIR__;

	return date(DATE_RSS, filemtime($fromFile));
}

function getHostUrl() {
	$scheme = ($_SERVER['HTTPS'] === 'on') ? 'https' : 'http';

	return $scheme . '://' . $_SERVER['SERVER_NAME'];
}

function getBaseUrl() {
	return getHostUrl() .
		dirname($_SERVER['REQUEST_URI']) . '/';
}

function getSelfUrl() {
	return getHostUrl() . $_SERVER['PHP_SELF'];
}

function getCoverArt() {
	$coverartFile = glob(COVER_ART_FILE_NAME, GLOB_BRACE)[0];

	if (!is_file($coverartFile)) {
		return false;
	}

	return [
		'url' => getBaseUrl() . $coverartFile
	];
}

function getItems() {
	$files = getAudioFiles();

	foreach ($files as $file) {
		$items[] = [
			'title' => getReadableTitle(pathinfo($file, PATHINFO_FILENAME)),
			'pubDate' => getPubDate($file),
			'link' => '',
			'description' => '',
			'length' => '0',
			'type' => getAudioFileType($file),
			'url' => getBaseUrl() . $file,
		];
	}

	return $items;
}

function getAudioFiles() {
	return glob(AUDIO_FILE_TYPES, GLOB_BRACE);
}

function getAudioFileType($file) {
	$extension = pathinfo($file, PATHINFO_EXTENSION);
	$types = [
		'mp3' => 'audio/mpeg',
	];

	return $types[$extension];
}

function getReadableTitle($input) {
	return str_replace(
		[
			'_',
		],
		[
			' ',
		],
		$input
	);
}

//
// Output Feed:
//
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:cc="http://web.resource.org/cc/"
     xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
>
	<channel>
		<atom:link href="<?=$channel['self']?>" rel="self" type="application/rss+xml" />
		<title><?=$channel['title']?></title>
		<pubDate><?=$channel['pubDate']?></pubDate>
		<link><?=$channel['link']?></link>
<?php if (!empty($channel['language'])): ?>
		<language><?=$channel['language']?></language>
<?php endif; ?>
<?php if (!empty($channel['copyright'])): ?>
		<copyright><![CDATA[<?=$channel['copyright']?>]]></copyright>
<?php endif; ?>
<?php if (!empty($channel['image'])): ?>
		<image>
			<title><?=$channel['title']?></title>
			<link><?=$channel['link']?></link>
			<url><?=$channel['image']['url']?></url>
		</image>
<?php endif; ?>
		<description><![CDATA[<?=$channel['description']?>]]></description>

<?php foreach ($channel['items'] as $index => $item): ?>
			<item>
				<title><?=$item['title']?></title>
				<pubDate><?=$item['pubDate']?></pubDate>
				<guid isPermaLink="false"><![CDATA[<?=$channel['link'] . "?" . $index?>]]></guid>
<?php if (!empty($item['link'])): ?>
					<link><![CDATA[<?=$item['link']?>]]></link>
<?php endif; ?>
<?php if (!empty($item['description'])): ?>
					<description><![CDATA[<?=$item['description']?>]]></description>
<?php endif; ?>
				<enclosure length="<?=$item['length']?>"
				           type="<?=$item['type']?>"
				           url="<?=$item['url']?>"
				/>
			</item>
<?php endforeach; ?>

	</channel>
</rss>
