<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pattern',
        'response',
        'response_type',
        'priority',
        'is_active',
        'conditions',
        'actions',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'conditions' => 'array',
        'actions' => 'array',
        'metadata' => 'array',
        'priority' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    public function matchesPattern($message)
    {
        return preg_match('/' . $this->pattern . '/i', $message);
    }

    public function evaluateConditions($context = [])
    {
        if (empty($this->conditions)) {
            return true;
        }

        foreach ($this->conditions as $condition) {
            if (!$this->evaluateCondition($condition, $context)) {
                return false;
            }
        }

        return true;
    }

    private function evaluateCondition($condition, $context)
    {
        $field = $condition['field'] ?? null;
        $operator = $condition['operator'] ?? '=';
        $value = $condition['value'] ?? null;

        if (!$field || !isset($context[$field])) {
            return false;
        }

        $contextValue = $context[$field];

        switch ($operator) {
            case '=':
            case '==':
                return $contextValue == $value;
            case '!=':
                return $contextValue != $value;
            case '>':
                return $contextValue > $value;
            case '>=':
                return $contextValue >= $value;
            case '<':
                return $contextValue < $value;
            case '<=':
                return $contextValue <= $value;
            case 'contains':
                return strpos(strtolower($contextValue), strtolower($value)) !== false;
            case 'starts_with':
                return strpos(strtolower($contextValue), strtolower($value)) === 0;
            case 'ends_with':
                return substr(strtolower($contextValue), -strlen($value)) === strtolower($value);
            case 'in':
                return in_array($contextValue, (array) $value);
            default:
                return false;
        }
    }
}