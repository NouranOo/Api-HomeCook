<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'Title_en' => $this->Title_en,
            'Title_ar' => $this->Title_ar,
            'Description_en' => $this->Description_en,
            'Description_ar' => $this->Description_ar,
            'Ingredients_en' => $this->Ingredients_en,
            'Ingredients_ar' => $this->Ingredients_ar,
            'KitchenType_id' => $this->KitchenType_id,
            'Price' => $this->Price,
            'Expected_time' => $this->Expected_time,
            'Saturday' => $this->Saturday,
            'Sunday' => $this->Sunday,
            'Monday' => $this->Monday,
            'Tuesday' => $this->Tuesday,
            'Wednesday' => $this->Wednesday,
            'Thursday' => $this->Thursday,
            'Friday' => $this->Friday,
            'Photo1' => $this->Photo1,
            'Photo2' => $this->Photo2,
            'Photo3' => $this->Photo3,
            'Photo4' => $this->Photo4,
            'cooker_name'=>$this->Cooker->Kitchen_Name,
            'kitchen_type_name_en' => $this->KitchenType->Name_en,
            'kitchen_type_name_ar' => $this->KitchenType->Name_ar,
            'rating' =>$this->Cooker->rate,

        ];
    }


}
