{!! '<' . '?' . 'xml version="1.0" encoding="UTF-8"?>' . "\n" !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
  <channel>
    <atom:link href="{{ request()->url() }}" rel="self" type="application/rss+xml" />
    <title>{{ $channel['title'] }}</title>
    <link>{{ $channel['link'] }}</link>
    @foreach ($items as $item)
      <item>
        <link>{{ $item['loc'] }}</link>
        <title>{{ $item['title'] }}</title>
        @if(!empty($item['description']))
          <description><![CDATA[{!! $item['description'] !!}]]></description>
        @endif
        @if(!empty($item['author']))
         <author>{{ $item['author'] }}</author>
        @endif
        @if ($item['lastmod'])
          <pubDate>{{ \Carbon\Carbon::parse($item['lastmod'])->toRfc2822String() }}</pubDate>
        @endif
        <guid isPermaLink="true">{{ $item['loc'] }}</guid>
        @foreach ($item['images'] as $image)
          <media:content url="{{ $image['url'] }}" />
        @endforeach
      </item>
    @endforeach
  </channel>
</rss>