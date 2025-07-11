<h2>Hi {{ $user->name ?? ($user->f_name . ' ' . $user->l_name) }}</h2>
<p>Your buy lead <strong>{{ $lead->details }}</strong> has been reviewed and approved.</p>
<p>You can expect vendor responses soon.</p>
