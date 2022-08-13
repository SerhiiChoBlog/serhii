<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">
<p>
© {{ date('Y') }} {{ config('app.name') }}
<br />
You are receiving this because you subscribed to new posts on {{ config('app.name') }}.
</p>
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
</td>
</tr>
