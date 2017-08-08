<nav class="nav">
    <div class="container">
        <div class="nav-left">
            <a href="{{ route('home') }}" class="nav-item is-brand">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
        <span class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </span>
        <div class="nav-right nav-menu">
             @if (auth()->guest())
                 <a href="{{ route('login') }}" class="nav-item">
                     Sign in
                 </a>
                 <div class="nav-item">
                     <a href="{{ route('register') }}" class="button">
                         Start selling
                     </a>
                 </div>
             @else
                 <a href="#" class="nav-item"
                     onclick="event.preventDefault();
                                 document.getElementById('logout').submit();">
                     Sign out
                 </a>
                 <a href="{{ route('account.index') }}" class="nav-item">
                     Your account
                 </a>
                 @role('admin')
                     <a href="{{ route('admin.index') }}" class="nav-item">
                         Admin
                     </a>
                 @endrole
             @endif
        </div>
    </div>
</nav>

<form id="logout" action="{{ route('logout') }}" method="POST" class="is-hidden">
    {{ csrf_field() }}
</form>
