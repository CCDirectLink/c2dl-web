{!! '<'.'?xml version="1.0" encoding="utf-8"?>' !!}
<feed xmlns="http://www.w3.org/2005/Atom">

    <title>News | CCDirectLink</title>
    <subtitle>General news regarding CrossCode Modding</subtitle>

    <link rel="alternate" href="{{ url('/cc/') }}"/>
    <link rel="self" href="{{ url('/cc/news/feed') }}"/>
    <updated>{{ $lastUpdate->format(DateTimeInterface::ATOM) }}</updated>
    <author>
       <name>CCDirectLink</name>
    </author>
    <id>{{ url('/cc/news/feed') }}</id>
    {!! '<generator version="1.0.0">c2dl-feedly</generator>' !!}

    @foreach ($posts as $post)
    <entry>
        <title>{{ $post->title }}</title>
        <published>{{ $post->created(DateTimeInterface::ATOM, 'UTC', 'GR') }}</published>
        @if ( $post->is_updated() )
        <updated>{{ $post->updated(DateTimeInterface::ATOM, 'UTC', 'GR') }}</updated>
        @else
        <updated>{{ $post->created(DateTimeInterface::ATOM, 'UTC', 'GR') }}</updated>
        @endif
        <author>
            <name>{{ $post->author->name }}</name>
        </author>
        <link rel="alternate" href="{{ url('/cc/news/' . $post->id . '/' . $post->page->current) }}"/>
        <summary>{{ $post->preview->content }}</summary>
        <id>{{ url('/cc/news/' . $post->id . '/' . $post->page->current) }}</id>
    </entry>
    @endforeach
</feed>
