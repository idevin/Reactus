@if(count($bestOfDay) > 0 || count($bestOfWeek) > 0 || count($bestOfMonth) > 0)
    <section class="best">

        <h2 class="main-heading">
            ЛУЧШЕЕ ЗА &nbsp;
            <span class="best-range-switcher current" data-range="day" data-date="{{ $timeIntervals['day'] }}">ДЕНЬ</span>
            <span class="icon slider-next"></span>
            <span class="best-range-switcher" data-range="week" data-date="{{ $timeIntervals['week'] }}">НЕДЕЛЮ</span>
            <span class="icon slider-next"></span>
      <span class="best-range-switcher" data-range="month"
            data-date="{{ $timeIntervals['month'] }}">МЕСЯЦ</span>
        </h2>

        <div class="custom-dropdown visible-xs" id="best-dropdown">
            <p class="custom-dropdown-toggle">Лучшее за день</p>
            <ul class="custom-dropdown-list">
                <li class="custom-dropdown-item current" data-range="day" data-date="{{ $timeIntervals['day'] }}">Лучшее за день</li>
                <li class="custom-dropdown-item" data-range="week" data-date="{{ $timeIntervals['week'] }}">Лучшее за неделю</li>
                <li class="custom-dropdown-item" data-range="month" data-date="{{ $timeIntervals['month'] }}">Лучшее за месяц</li>
            </ul>
        </div>
        <p id="best-date" class="best-date">{{ $timeIntervals['day'] }}</p>

        <div class="carousel best-carousel">
            <div id="best-carousel" class="list-unstyled">


                @if (count($bestOfDay) > 0)
                    @foreach ($bestOfDay as $item)
                        @include(theme('home.best-carousel-item'), ['article' => $item, 'interval' => 'day'])
                    @endforeach
                @endif

                @if (count($bestOfWeek) > 0)
                    @foreach ($bestOfWeek as $item)
                        @include(theme('home.best-carousel-item'), ['article' => $item, 'interval' => 'week'])
                    @endforeach
                @endif

                @if (count($bestOfMonth) > 0)
                    @foreach ($bestOfMonth as $item)
                        @include(theme('home.best-carousel-item'), ['article' => $item, 'interval' => 'month'])
                    @endforeach
                @endif

            </div>
        </div>
    </section>
@endif
