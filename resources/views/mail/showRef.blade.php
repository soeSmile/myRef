<h1>Напоминание о ссылке</h1>
<br/>
<div>Вы поставили напоминание на просмотр ссылки.</div>
<br/>
<div>Имя ссылка: {{ $link->title }}</div>
<br/>
<div>Описание: {{ $link->desc }}</div>
<hr/>
<div>
    <a href="{{ \Config::get('app.url') . '/link/' . $link->id }}">Ссылка</a>
</div>