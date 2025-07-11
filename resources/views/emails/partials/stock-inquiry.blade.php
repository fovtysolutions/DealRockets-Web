<h2>Hi {{ $buyer->name ?? ($buyer->f_name . ' ' . $buyer->l_name) }}</h2>
<p>You have a new response to your sale offer <strong>{{ $lead->details }}</strong>.</p>
<p>Check your dashboard to review the offer.</p>
