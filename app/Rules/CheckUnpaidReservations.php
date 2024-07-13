<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Reserve;

class CheckUnpaidReservations implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $unpaidReservationsCount = Reserve::where('user_id', $value)
            ->where('is_payed', false)
            ->count();

        if ($unpaidReservationsCount >= 3) {
            $fail('You have 3 or more unpaid reservations. Please pay your existing reservations before making a new one.');
        }
    }
}