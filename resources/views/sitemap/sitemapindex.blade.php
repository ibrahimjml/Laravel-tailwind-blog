{!! '<' . '?' . 'xml version="1.0" encoding="UTF-8"?>' . "\n" !!}
@if (null != $style)
    {!! '<' . '?' . 'xml-stylesheet href="' . asset($style) . '" type="text/xsl"?>' . "\n" !!}
@endif
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($sitemaps as $sitemap)
        <sitemap>
            <loc>{{ $sitemap['loc'] }}</loc>
            @if ($sitemap['lastmod'] !== null)
                <lastmod>{{ \Carbon\Carbon::parse($sitemap['lastmod'])->toAtomString() }}</lastmod>
            @endif
        </sitemap>
    @endforeach
</sitemapindex>
