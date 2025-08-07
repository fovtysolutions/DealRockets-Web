<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 700px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .required {
            color: #dc3545;
        }
        .btn-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
        }
        .plan-comparison {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
        }
        .plan-feature {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #dee2e6;
        }
        .plan-feature:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <i class="fas fa-crown fa-3x text-warning mb-3"></i>
                <h2>{{ $title }}</h2>
                <p class="text-muted">Upgrade your membership to unlock premium features</p>
            </div>

            <div class="plan-comparison">
                <h5><i class="fas fa-chart-line"></i> Plan Comparison</h5>
                <div class="plan-feature">
                    <span>Current Plan:</span>
                    <span class="badge bg-secondary">Basic</span>
                </div>
                <div class="plan-feature">
                    <span>Products Allowed:</span>
                    <span>5 → Unlimited</span>
                </div>
                <div class="plan-feature">
                    <span>Lead Generation:</span>
                    <span>2 → Unlimited</span>
                </div>
                <div class="plan-feature">
                    <span>Support Level:</span>
                    <span>Email → 24/7 Priority</span>
                </div>
            </div>

            <form action="{{ $action }}" method="POST">
                @csrf
                
                @foreach($fields as $field)
                    <div class="form-group">
                        <label for="{{ $field['name'] }}" class="form-label">
                            {{ $field['label'] }}
                            @if($field['required'])
                                <span class="required">*</span>
                            @endif
                        </label>
                        
                        @if($field['type'] === 'text')
                            <input type="text" 
                                   class="form-control" 
                                   id="{{ $field['name'] }}" 
                                   name="{{ $field['name'] }}" 
                                   value="{{ $field['name'] === 'current_plan' ? 'Basic (Free)' : '' }}"
                                   {{ isset($field['readonly']) && $field['readonly'] ? 'readonly' : '' }}
                                   {{ $field['required'] ? 'required' : '' }}>
                        
                        @elseif($field['type'] === 'select')
                            <select class="form-control" 
                                    id="{{ $field['name'] }}" 
                                    name="{{ $field['name'] }}" 
                                    {{ $field['required'] ? 'required' : '' }}>
                                <option value="">Select {{ $field['label'] }}</option>
                                @if(isset($field['options']))
                                    @foreach($field['options'] as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                @endif
                            </select>
                        
                        @elseif($field['type'] === 'checkbox')
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="{{ $field['name'] }}" 
                                       name="{{ $field['name'] }}" 
                                       value="1"
                                       {{ $field['required'] ? 'required' : '' }}>
                                <label class="form-check-label" for="{{ $field['name'] }}">
                                    {{ $field['label'] }}
                                </label>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note:</strong> Your upgrade will be processed immediately and you'll have access to all premium features right away.
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-credit-card"></i> Upgrade Now
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>