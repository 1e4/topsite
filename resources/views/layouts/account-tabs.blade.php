<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link @if(request()->route()->getName() === 'account.password') active @endif" href="{{ route('account.password') }}">Change Password</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->route()->getName() === 'account.email') active @endif" href="{{ route('account.email') }}">Update Email</a>
    </li>
</ul>