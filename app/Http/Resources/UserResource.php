<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'UserName' => $this->UserName,
            'Kitchen_Name' => $this->Kitchen_Name,
            'Nationality' => $this->Nationality,
            'Phone' => $this->Phone,
            'Late' => $this->Late,
            'Long' => $this->Long,
            'Area' => $this->Area,
            'City' => $this->City,
            'Country' => $this->Country,
            'Email' => $this->Email,
            'Password' => $this->Password,
            'Photo' => $this->Photo,
            'ApiToken' => $this->ApiToken,
            'Token' => $this->Token,
            'IsAvailable' => $this->IsAvailable,
            'IsConfirmed' => $this->IsConfirmed,
            'HavePayment' => $this->HavePayment,
            'National_ID' => $this->National_ID,
            'Bank_Account' => $this->Bank_Account,
            'UserType' => $this->UserType,
            'VerifyCode' => $this->VerifyCode,
            'IsVerified' => $this->IsVerified,
            'AvailableNotification' => $this->AvailableNotification,
            'remember_token' => $this->remember_token,
            'Created_at' => $this->Created_at,
            'Updated_at' => $this->Updated_at,
            'rate' => $this->rate,
            'kitchen_types' => $this->kitchen_types,
            'distance'=>$this->distance
        ];
    }
}
