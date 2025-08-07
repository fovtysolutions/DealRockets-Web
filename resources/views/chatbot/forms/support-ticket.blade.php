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
            max-width: 600px;
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
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
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
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <i class="fas fa-life-ring fa-3x text-primary mb-3"></i>
                <h2>{{ $title }}</h2>
                <p class="text-muted">We're here to help! Describe your issue and we'll get back to you soon.</p>
            </div>

            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @foreach($fields as $field)
                    <div class="form-group">
                        <label for="{{ $field['name'] }}" class="form-label">
                            {{ $field['label'] }}
                            @if($field['required'])
                                <span class="required">*</span>
                            @endif
                        </label>
                        
                        @if($field['type'] === 'text' || $field['type'] === 'email')
                            <input type="{{ $field['type'] }}" 
                                   class="form-control" 
                                   id="{{ $field['name'] }}" 
                                   name="{{ $field['name'] }}" 
                                   {{ $field['required'] ? 'required' : '' }}>
                        
                        @elseif($field['type'] === 'textarea')
                            <textarea class="form-control" 
                                      id="{{ $field['name'] }}" 
                                      name="{{ $field['name'] }}" 
                                      rows="4" 
                                      {{ $field['required'] ? 'required' : '' }}></textarea>
                        
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
                        
                        @elseif($field['type'] === 'file')
                            <input type="file" 
                                   class="form-control" 
                                   id="{{ $field['name'] }}" 
                                   name="{{ $field['name'] }}" 
                                   {{ $field['required'] ? 'required' : '' }}>
                        @endif
                    </div>
                @endforeach

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>