
<aside class="menu">
    <p class="menu-label">
        Esempi
    </p>
    <ul class="menu-list">
        {{ Route::currentRouteName(); }}
        <li><a class="{{ Route::currentRouteName() == 'home' ? 'is_active': ''; }}" href={{ route('home') }}>Home</a></li>
        <li><a href={{ route('static-props') }}>Elementi statici</a></li>
        <li><a href={{ route('metrics') }}>Metriche</a></li>
    </ul>
    <p class="menu-label">
        Administration
    </p>
    <ul class="menu-list">
        <li><a>Team Settings</a></li>
        <li>
            <a class="is-active">Manage Your Team</a>
            <ul>
                <li><a>Members</a></li>
                <li><a>Plugins</a></li>
                <li><a>Add a member</a></li>
            </ul>
        </li>
        <li><a>Invitations</a></li>
        <li><a>Cloud Storage Environment Settings</a></li>
        <li><a>Authentication</a></li>
    </ul>
    <p class="menu-label">
        Transactions
    </p>
    <ul class="menu-list">
        <li><a>Payments</a></li>
        <li><a>Transfers</a></li>
        <li><a>Balance</a></li>
    </ul>
</aside>
