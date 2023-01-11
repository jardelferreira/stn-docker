<hr>
<nav aria-label="breadcrumb" id="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('public.index') }}">Página principal</a></li>
            @foreach ($breadcrumb as $item)
            <li class="breadcrumb-item"><a href="{{ route($item['url']) }}">{{$item['name']}}</a></li>
            
            @endforeach
            <li class="breadcrumb-item active" aria-current="page">{{$current}}</li>
    </ol>
</nav>
<hr>