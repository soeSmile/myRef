<?php
declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'timeZone' => $this->time_zone,
            'show'     => $this->show,
            'link'     => $this->link,
            'isAdmin'  => $this->isAdmin(),
            'isClient' => $this->isClient(),
            'links'    => $this->searchLinks
        ];
    }
}
