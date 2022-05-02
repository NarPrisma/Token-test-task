<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $request
     * @return bool
     */
    public static function  store($request): bool
    {
        $token = new self();
        $token->user_id = auth()->id();
        $token->token_name = $request->token_name;
        $token->symbol = $request->symbol;
        $token->contract_address = $request->contract_address ?? '';
        $token->count = $request->count;
        $token->price = $request->price;
        $token->index = $request->index;
        $token->save();
        return true;
    }

}
