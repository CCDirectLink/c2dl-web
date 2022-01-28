<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title>
            News | CCDirectLink
        </title>
        <description>
            General news regarding CrossCode Modding.
        </description>
        <link>
            <![CDATA[ {{ url('/') }} ]]>
        </link>
        @foreach ($posts as $post)
            <item>
                <title>
                    <![CDATA[ {{ $post->title }} ]]>
                </title>
                <description>
                    <![CDATA[ {{ $post->preview->content }} ]]>
                </description>
                <author>
                    <![CDATA[ {{ $post->author->name }} ]]>
                </author>
                <link><![CDATA[ {{ url('/cc/news/' . $post->id . '/' . $post->page->current) }} ]]></link>

                <guid isPermaLink="false"><![CDATA[ {{ url('/cc/news/' . $post->id . '/' . $post->page->current) }} ]]></guid>
                <pubDate>{{ $post->_created->format(DateTime::RFC822) }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
