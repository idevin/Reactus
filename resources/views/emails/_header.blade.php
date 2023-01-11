<div style="background-color: #f1f3f5; margin: 0 auto; padding: 10px;">

    <table align="center" style="margin:15px auto;">
        <tbody>
        <tr>
            <td>
                @if(!empty($_site->logo_thumbs['thumb70x70']))
                    <img src="{{$message->embed($_doc_root . DS . parse_url($_site->logo_thumbs['thumb70x70'], PHP_URL_PATH))}}">
                @endif
            </td>
            <td>
                @if($_site->title)
                    <span style="font-size: 22px;">
                        {{$_site->title}}
                    </span>
                @endif
                <br/>

                @if($_site->slogan)
                    {{$_site->slogan}}
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <br>

    <table style="background-color: white;" width="90%" align="center">
        <tbody>
        <tr>
            <td style="padding: 10px 10px 10px 20px;">

                <h1>{{$_subject}}</h1>