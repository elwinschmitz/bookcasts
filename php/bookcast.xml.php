<?php
// 📚🔈 BookCasts
// See: https://github.com/elwinschmitz/bookcasts
//

// 
// Configure / Setup data: 
//
$channel = [
	"title" => getFolderTitle(),
	"pubDate" => getPubDate(),
	"link" => getBaseUrl(),
	"language" => "en",
	"copyright" => "",
	"image" => [
		"url" => "https://example.com/this-bookcast/coverart.jpg",
	],
	"description" => "Channel description",
	"items" => [
		[
			"title" => "Item title",
			"pubDate" => "Mon, 01 Jan 0000 00:00:01 +0000",
			"link" => "",
			"description" => "",
			"length" => "1",
			"type" => "audio/mpeg",
			"url" => "https://example.com/this-bookcast/chapter-1.mp3",
		],
		// Repeat 👆 for every file(chapter, episode, etc...)
	],
];


function getFolderTitle() {
	return basename(__DIR__);
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
	dirname($_SERVER['REQUEST_URI']);
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
