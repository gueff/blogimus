<?xml version="1.0"?>
<rss version="0.92">
    <channel>
        <title>{$sTitle}</title>
        <link>{$sUrl}</link>
        <description>{$sDescription}</description>
    </channel>
    {if isset($sItem) && !empty($sItem)}{$sItem}{else}<item></item>{/if}
</rss>
