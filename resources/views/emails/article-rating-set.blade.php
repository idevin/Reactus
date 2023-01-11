@include('emails/_header')

Пользователь <b>{{username($user)}}</b> поставил Оценку <b>{{$ratingValue}}</b> к статье

<a target="_blank" href="{{route('article.show', ['title' => $article->title, 'id' => $article->id])}}">{{$article->title}}</a>

@include('emails/_footer')
