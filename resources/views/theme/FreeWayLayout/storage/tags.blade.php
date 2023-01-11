<div class="user-tags">
    <div class="new-user-tag-wrapper"></div>

    @foreach($user_tags as $tag)
        @include(theme('storage.user-tag'))
    @endforeach
</div>
