<?php
// 📚🔈 BookCasts
// See: https://github.com/elwinschmitz/bookcasts
//

// 
// Configure Options:
//
define('META_DATA_FILE_NAME', 'metadata{.ini,}');
define('COVER_ART_FILE_NAME', 'coverart.jpg');
define('AUDIO_FILE_TYPE', '.mp3');
define('AUDIO_FILE_MIMETYPE', 'audio/mpeg');

// 
// Setup data: 
//
$metaData = getMetaData();

$channel = [
	"title" => getFolderTitle(),
	"pubDate" => getPubDate(),
	"link" => (!empty($metaData["link"])) ? $metaData["link"] : getBaseUrl(),
	"language" => $metaData["language"],
	"copyright" => $metaData["copyright"],
	"image" => getCoverArt(),
	"description" => $metaData["description"],
	"items" => getItems(),
];

// 
// Functions:
//
function getMetaData() {
	$defaults = [
		"language" => "en",
		"copyright" => "",
		"description" => "",
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

function getBaseUrl() {
	return 
	($_SERVER['HTTPS'] === 'on') ? 'https' : 'http' .
	'://' .
	$_SERVER['SERVER_NAME'] .
	dirname($_SERVER['REQUEST_URI']) . '/';
}

function getCoverArt() {
	$hasCoverart = is_file(COVER_ART_FILE_NAME);
	
	if (!$hasCoverart) {
		return false;
	}

	return [
		"url" => getBaseUrl() . COVER_ART_FILE_NAME
	];
}

function getItems() {
	$files = getAudioFiles();

	foreach ($files as $file) {
		$items[] = [
			"title" => getReadableTitle($file),
			"pubDate" => getPubDate($file),
			"link" => "",
			"description" => "",
			"length" => "1",
			"type" => AUDIO_FILE_MIMETYPE,
			"url" => getBaseUrl() . $file,
		];
	}

	return $items;
}

function getAudioFiles() {
	return glob('*' . AUDIO_FILE_TYPE);
}

function getReadableTitle($input) {
	return str_replace(
		[
			AUDIO_FILE_TYPE,
			'_',
		],
		[
			'',
			' ',
		],
		$input);
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
		<image><url><?=$channel['image']['url']?></url></image>
<?php endif; ?>
<?php if (!empty($channel['description'])): ?>
		<description><![CDATA[<?=$channel['description']?>]]></description>
<?php endif; ?>

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
