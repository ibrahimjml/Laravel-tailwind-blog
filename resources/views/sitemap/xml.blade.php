{!! '<' . '?' . 'xml version="1.0" encoding="UTF-8"?>' . "\n" !!}
@if (null != $style)
    {!! '<' . '?' . 'xml-stylesheet href="' . asset($style) . '" type="text/xsl"?>' . "\n" !!}
@endif
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="http://www.w3.org/1999/xhtml"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
>
    @foreach ($items as $item)
        <url>
            <loc>{{ $item['loc'] }}</loc>
          
            @if ($item['priority'] !== null)
                <priority>{{ $item['priority'] }}</priority>
            @endif

            @if ($item['lastmod'] !== null)
                <lastmod>{{ \Carbon\Carbon::parse($item['lastmod'])->toAtomString() }}</lastmod>
            @endif

            @if ($item['freq'] !== null)
                <changefreq>{{ $item['freq'] }}</changefreq>
            @endif

            @if (!empty($item['images']))
                @foreach ($item['images'] as $image)
                    <image:image>
                        <image:loc>{{ $image['url'] }}</image:loc>
                        @if (isset($image['title']))
                            <image:title>{{ $image['title'] }}</image:title>
                        @endif
                        @if (isset($image['caption']))
                            <image:caption>{{ $image['caption'] }}</image:caption>
                        @endif
                        @if (isset($image['geo_location']))
                            <image:geo_location>{{ $image['geo_location'] }}</image:geo_location>
                        @endif
                        @if (isset($image['license']))
                            <image:license>{{ $image['license'] }}</image:license>
                        @endif
                    </image:image>
                @endforeach
            @endif

          
        </url>
    @endforeach
</urlset>
