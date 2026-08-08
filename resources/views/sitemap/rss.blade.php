{!! '<' . '?' . 'xml version="1.0" encoding="UTF-8"?>' . "\n" !!}
<rss version="2.0" 
xmlns:atom="http://www.w3.org/2005/Atom" 
xmlns:content="http://purl.org/rss/1.0/modules/content/"
xmlns:media="http://search.yahoo.com/mrss/"
>
  <channel>
    <atom:link href="{{ request()->url() }}" rel="self" type="application/rss+xml" />
    <title>{{ $channel['title'] }}</title>
    @if (!empty($channel['description']))
        <description><![CDATA[{{ $channel['description'] }}]]></description>
    @endif
    <link>{{ $channel['link'] }}</link>
    @if (!empty($channel['image']))
        <image>
            <url>{{ $channel['image'] }}</url>
            <title>{{ $channel['title'] }}</title>
            <link>{{ $channel['link'] }}</link>
        </image>
    @endif
    @foreach ($items as $item)
      <item>
        <link>{{ $item['loc'] }}</link>
        <title>{{ $item['title'] }}</title>
        @if(!empty($item['short_excerpt']))
        <description><![CDATA[{!! $item['short_excerpt'] !!}]]></description>
        @endif
        @if(!empty($item['description']))
          <content:encoded><![CDATA[{!! $item['description'] !!}]]></content:encoded>
        @endif
        @if(!empty($item['author']))
         <author>{{ $item['author'] }}</author>
        @endif
        @if ($item['lastmod'])
          <pubDate>{{ \Carbon\Carbon::parse($item['lastmod'])->toRfc2822String() }}</pubDate>
        @endif
        <guid isPermaLink="true">{{ $item['loc'] }}</guid>
        @if (!empty($item['images']))
          <media:content url="{{ $item['images']['url'] }}" />
        @endif
      </item>
    @endforeach
  </channel>
</rss>