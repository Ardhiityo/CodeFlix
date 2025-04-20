<x-mail::message>
Hello, {{ $userName }}.

Expired date : {{ $expiredDate }}.

<x-mail::button :url="$actionUrl">
Renew subscription
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
