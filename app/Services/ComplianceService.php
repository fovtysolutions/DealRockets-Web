<?php

namespace App\Services;

class ComplianceService
{
    public static function checkStockSaleCompliance($data)
    {
        $prohibitedKeywords = ['fraud', 'scam', 'illegal'];
        foreach ($prohibitedKeywords as $keyword) {
            if (stripos($data['description'], $keyword) !== false) {
                return 'flagged';
            }
        }

        // Example: Flag if price is too high or too low
        if (isset($data['price']) && ($data['price'] < 10 || $data['price'] > 10000)) {
            return 'flagged';
        }

        // Example: Flag if quantity is unrealistic
        if (isset($data['quantity']) && $data['quantity'] > 100000) {
            return 'flagged';
        }

        return 'approved';
    }

    public static function checkLeadCompliance($data)
    {
        // Example: Flag if details contain prohibited keywords
        $prohibitedKeywords = ['fraud', 'scam', 'illegal'];
        foreach ($prohibitedKeywords as $keyword) {
            if (stripos($data['details'], $keyword) !== false) {
                return 'flagged';
            }
        }

        // Example: Flag if quantity is unrealistic
        if (isset($data['quantity_required']) && $data['quantity_required'] > 100000) {
            return 'flagged';
        }

        // Example: Flag if contact number is invalid
        if (!preg_match('/^[0-9]{10,15}$/', $data['contact_number'])) {
            return 'flagged';
        }

        return 'approved';
    }
}