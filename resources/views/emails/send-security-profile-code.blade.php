@include('emails/_header')

Ваш код для смены {{$codeTypes[$codeType]}}:

<div align="center">
    {{$code}}
</div>

@include('emails/_footer')