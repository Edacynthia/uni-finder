<x-mail::message>
# Hello {{ $userName }},

We’ve reviewed the issue you reported.  
Here’s our update:

---

{{ $replyMessage }}

---

If you have further questions, feel free to reach out again.

<x-mail::button :url="config('app.url')">
Go to {{ config('app.name') }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
