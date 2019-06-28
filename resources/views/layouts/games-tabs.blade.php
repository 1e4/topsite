<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link @if(request()->route()->getName() === 'front.game.index') active @endif" href="{{ route('front.game.index') }}">Your submissions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->route()->getName() === 'front.game.create') active @endif" href="{{ route('front.game.create') }}">Submit a new game</a>
    </li>
</ul>