<nav class="topbar mx-auto" style="background-color: rgba(0,0,0,.85); padding: 15px;">
    <div>
        <form method="get" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</nav>
