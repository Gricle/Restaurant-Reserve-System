<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Reserve;
use App\Models\User;

class BlockUnpaidUserRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::findOrFail($value);
        $unpaidReservationsCount = Reserve::where('user_id', $value)
            ->where('is_payed', false)
            ->count();
    
        if ($unpaidReservationsCount >= 3 && !$user->is_blocked) {
            $user->update(['is_blocked' => true]);
            $fail('Your account has been blocked due to 3 or more unpaid reservations. Please contact support.');
        } elseif ($unpaidReservationsCount <= 2 && $user->is_blocked) {
            $user->update(['is_blocked' => false]);
            // You might want to add a success message here, but validation rules typically only return failures
        }
    }
}