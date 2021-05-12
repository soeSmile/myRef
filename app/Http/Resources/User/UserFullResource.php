<?php
declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserFullResource
 * @package App\Http\Resources\User
 */
class UserFullResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'confirm'   => $this->confirm,
            'timeZone'  => $this->time_zone,
            'role'      => $this->role,
            'updatedAt' => $this->updated_at,
        ];
    }
}
