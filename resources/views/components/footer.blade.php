<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-bottom mt-5">    
    <a class="navbar-brand mx-auto" href="{{ url('/') }}">        
        {{ config('app.name', 'Laravel') }}
    </a>
    <label>
            <a href="{{ route('privacy') }}">プライバシーポリシー</a>
    </label>
    <label>&nbsp|&nbsp</label>
    <label>
            <a href="{{ route('tokuteis.tokutei', ['id' => 1]) }}">特定商取引法</a>
    </label>
</nav>