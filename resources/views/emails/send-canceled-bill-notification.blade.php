@include('emails/_header')


<p>
    У Вас истек срок тарифа "{{$bill->tariff->name}}" на сайте {{$bill->site->domain}}
</p>

<p>
    Автопродление

    @if($bill->autorenew == 0)
        выключено
    @else
        включено
    @endif
</p>

<p>
    @if($bill->autorenew == 1)
        @if($user->balance >= $bill->discount->discount_price)
            C Вашего профиля завтра будет списано {{$bill->discount->discount_price}}р.
        @else
            На Вашем балансе не достаточно средств для оплаты тарифа. Пополните баланс.
        @endif
    @endif
</p>

@include('emails/_footer')