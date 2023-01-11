@if(isset($communities) && !empty($communities->toArray()))
    <div class="sidebar-block">
        <div class="communities">
            <div class="communities-title">
                <strong>СООБЩЕСТВА</strong>
            </div>
            <div class="communities-body">
                @each(theme('home.sidebar-community-item'), $communities, 'community')
            </div>

            <div class="communities-all">
                <a href="{{ route('community.index') }}" class="btn btn-primary btn-block btn-lg">Все сообщества</a>
            </div>
        </div>
    </div>
@endif