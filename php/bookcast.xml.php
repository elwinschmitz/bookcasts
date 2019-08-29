<?php
// 📚🔈 BookCasts
// See: https://github.com/elwinschmitz/bookcasts
//

// 
// Configure / Setup data: 
//
$channel = [
	"title" => "Channel Title",
	"pubDate" => "Mon, 01 Jan 0000 00:00:00 +0000",
	"link" => "https://example.com/this-bookcast/",
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

//
// Output Feed:
//
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
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
		<language><?=$channel['language']?></language>
		<copyright><![CDATA[<?=$channel['copyright']?>]]></copyright>
		<image>
			<url><?=$channel['image']['url']?></url>
		</image>
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
