<h2>Hello {{ $user->name ?? ($user->f_name . ' ' . $user->l_name) }}</h2>
<p>Your buy lead <strong>{{ $lead->details }}</strong> has been posted successfully.</p>
<p>We'll notify vendors who match your interest.</p>
