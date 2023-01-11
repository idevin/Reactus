@include('emails/_header')

Пользователь <b>{{username($user)}}</b> поставил Оценку <b>{{$ratingValue}}</b> к коментарию

@include('emails/_footer')
