<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoogleAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'access_token',
        'refresh_token',
        'expires_in',
        'token_created_at',
        'google_account_email',
        'is_connected',
    ];

    protected $casts = [
        'token_created_at' => 'datetime',
        'is_connected' => 'boolean',
    ];

    /**
     * Get the user that owns the Google account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the access token is expired.
     */
    public function isTokenExpired(): bool
    {
        if (!$this->token_created_at) {
            return true;
        }

        return now()->gt($this->token_created_at->addSeconds($this->expires_in));
    }

    /**
     * Get the remaining time before token expires (in seconds).
     */
    public function getTokenExpiresIn(): int
    {
        if (!$this->token_created_at) {
            return 0;
        }

        return max(0, $this->token_created_at->addSeconds($this->expires_in)->diffInSeconds(now()));
    }

    /**
     * Update the access token and related data.
     */
    public function updateToken(string $accessToken, string $refreshToken, int $expiresIn): void
    {
        $this->update([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => $expiresIn,
            'token_created_at' => now(),
        ]);
    }

    /**
     * Disconnect the Google account.
     */
    public function disconnect(): void
    {
        $this->update([
            'is_connected' => false,
            'access_token' => null,
            'refresh_token' => null,
        ]);
    }

    /**
     * Reconnect the Google account.
     */
    public function reconnect(): void
    {
        $this->update([
            'is_connected' => true,
        ]);
    }
}
