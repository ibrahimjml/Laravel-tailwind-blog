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
                
                    <image:image>
                        <image:loc>{{ $item['images']['url'] }}</image:loc>
                        @if (isset($item['images']['title']))
                            <image:title>{{ $item['images']['title'] }}</image:title>
                        @endif
                        @if (isset($item['images']['caption']))
                            <image:caption>{{ $item['images']['caption'] }}</image:caption>
                        @endif
                        @if (isset($item['images']['geo_location']))
                            <image:geo_location>{{ $item['images']['geo_location'] }}</image:geo_location>
                        @endif
                        @if (isset($item['images']['license']))
                            <image:license>{{ $item['images']['license'] }}</image:license>
                        @endif
                    </image:image>
                
            @endif

          
        </url>
    @endforeach
</urlset>
