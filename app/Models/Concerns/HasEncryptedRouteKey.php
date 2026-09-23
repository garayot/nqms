<?php

namespace App\Models\Concerns;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

trait HasEncryptedRouteKey
{
    public function getRouteKey(): mixed
    {
        return Crypt::encryptString((string) $this->getKey());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $resolvedValue = Crypt::decryptString((string) $value);
        } catch (DecryptException $exception) {
            if (! is_numeric($value)) {
                return null;
            }

            $resolvedValue = $value;
        }

        return $this->newQuery()->where($field ?? $this->getRouteKeyName(), $resolvedValue)->first();
    }
}
