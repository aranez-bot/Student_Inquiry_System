<li class="nav-item">
    <a class="nav-link @if (Route::currentRouteName() == 'settings') active @endif" href="{{ route('settings') }}">
        <i class="fas fa-cog"></i> Settings
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @if (Route::currentRouteName() == 'about') active @endif" href="{{ route('about') }}">
        <i class="fas fa-info-circle"></i> About Us
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @if (Route::currentRouteName() == 'faqs') active @endif" href="{{ route('faqs') }}">
        <i class="fas fa-question-circle"></i> FAQs
    </a>
</li>
