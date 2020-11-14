<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use validator;
use App\Interfaces\UserInterface;

class UserController extends Controller
{

    public $user;
    public $apiResponse;
    /**
     * Create a new controller instance.
     *t
     * @return void
     */
    public function __construct(UserInterface $user ,ApiResponse $apiResponse)
    {
        //
        $this->user = $user;
        $this->apiResponse = $apiResponse;
    }

    public function welcome(){
        return $this->user->welcome();
    }
    public function verifyemail($id){

        $data = $id;
        $result = $this->user->verifyemail($data);
        return $result->send();
    }
    public function CookerSignUp(Request $request)
    {
        $rules = [
            'Name' => 'required',
            'Kitchen_Name' => 'required|unique:users',
            'Phone' => 'required|unique:users',
            'Password' => 'required',
            'Nationality' => 'required',
            'Late' => 'required',
            'Long' => 'required',
            'Area' => 'required',
            'City' => 'required',
            'Country' => 'required',
            'National_ID' => 'required',
            'Bank_Account' => 'required',
            'ApiKey' => 'required',

        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $api_key = env('APP_KEY');
        if ($api_key != $request->ApiKey) {
            return $this->apiResponse->setError("Unauthorized!")->send();
        }

        $data = $request->all();
        $result = $this->user->CookerSignUp($data);
        return $result->send();

    }

    public function CookerSignIn(Request $request)
    {
        $rules = [

            'Phone' => 'required',
            'Password' => 'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $api_key = env('APP_KEY');
        if ($api_key != $request->ApiKey) {
            return $this->apiResponse->setError("Unauthorized!")->send();
        }

        $data = $request->all();
        $result = $this->user->CookerSignIn($data);
        return $result->send();


    }

    public function getCookerMeals(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }


        $data = $request->all();
        $result = $this->user->getCookerMeals($data);
        return $result->send();


    }
    public function addCookMeal(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',
            'KitchenType_id' => '',
            'Title_en' => '',
            'Title_ar' => '',
            'Description_en' => '',
            'Description_ar' => '',
            // 'Ingredients_en' => '',
            // 'Ingredients_ar' => '',
            'Price' => '',
            'Expected_time' => '',
            'Saturday' => '',
            'Sunday' => '',
            'Monday' => '',
            'Tuesday' => '',
            'Wednesday' => '',
            'Thursday' => '',
            'Friday' => '',
            'Photo1' => '',
            'Photo2' => '',
            'Photo3' => '',
            'Photo4' => '',




        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->except(['Photo1','Photo2','Photo3','Photo4']);

        if ($request->hasFile('Photo1')) {

            $file = $request->file("Photo1");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/MealPhotos';
            $file->move($path, $filename);
            $data['Photo1'] = $path . '/' . $filename;
        }
        if ($request->hasFile('Photo2')) {

            $file = $request->file("Photo2");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/MealPhotos';
            $file->move($path, $filename);
            $data['Photo2'] = $path . '/' . $filename;
        }
        if ($request->hasFile('Photo3')) {

            $file = $request->file("Photo3");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/MealPhotos';
            $file->move($path, $filename);
            $data['Photo3'] = $path . '/' . $filename;
        }
        if ($request->hasFile('Photo4')) {

            $file = $request->file("Photo4");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/MealPhotos';
            $file->move($path, $filename);
            $data['Photo4'] = $path . '/' . $filename;
        }
        $result = $this->user->addCookMeal($data);
        return $result->send();


    }
    public function getAllKitchenTypes(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }


        $data = $request->all();
        $result = $this->user->getAllKitchenTypes($data);
        return $result->send();

    }
    public function updateProfile1(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',
            'Photo' => '',
            'Name' => '',
            'Kitchen_Name' => '',
            'Nationality' => '',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->except('Photo');

        if ($request->hasFile('Photo')) {

            $file = $request->file("Photo");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/UserPhotos';
            $file->move($path, $filename);
            $data['Photo'] = $path . '/' . $filename;
        }
        // $data = $request->all();
        $result = $this->user->updateProfile1($data);
        return $result->send();

    }
    public function updateProfile2(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',
            'Late' => '',
            'Long' => '',
            'Phone' => '',
            'National_ID' => '',
            'Bank_Account' => '',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $data = $request->all();
        $result = $this->user->updateProfile2($data);
        return $result->send();

    }
    public function changeOnlineStatus(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',
            'Online' => 'required',

        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $data = $request->all();
        $result = $this->user->changeOnlineStatus($data);
        return $result->send();

    }
    // public function TestDistance(Request $request)
    // {
    //     $data = $request->all();
    //     $result = $this->user->TestDistance($data);
    //     return $result->send();
    // }
    public function getAllNotifications(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $data = $request->all();
        $result = $this->user->getAllNotifications($data);
        return $result->send();

    }
    public function changeAvailableNotification(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',
            'AvailableNotification' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $data = $request->all();
        $result = $this->user->changeAvailableNotification($data);
        return $result->send();

    }
    public function editCookMeal(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',
            'CookMeal_id'=>'required',
            'KitchenType_id' => '',
            'Title_en' => '',
            'Title_ar' => '',
            'Description_en' => '',
            'Description_ar' => '',
            // 'Ingredients_en' => '',
            // 'Ingredients_ar' => '',
            'Price' => '',
            'Expected_time' => '',
            'Saturday' => '',
            'Sunday' => '',
            'Monday' => '',
            'Tuesday' => '',
            'Wednesday' => '',
            'Thursday' => '',
            'Friday' => '',
            'Photo1' => '',
            'Photo2' => '',
            'Photo3' => '',
            'Photo4' => '',




        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->except(['Photo1','Photo2','Photo3','Photo4']);

        if ($request->hasFile('Photo1')) {

            $file = $request->file("Photo1");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/MealPhotos';
            $file->move($path, $filename);
            $data['Photo1'] = $path . '/' . $filename;
        }
        if ($request->hasFile('Photo2')) {

            $file = $request->file("Photo2");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/MealPhotos';
            $file->move($path, $filename);
            $data['Photo2'] = $path . '/' . $filename;
        }
        if ($request->hasFile('Photo3')) {

            $file = $request->file("Photo3");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/MealPhotos';
            $file->move($path, $filename);
            $data['Photo3'] = $path . '/' . $filename;
        }
        if ($request->hasFile('Photo4')) {

            $file = $request->file("Photo4");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/MealPhotos';
            $file->move($path, $filename);
            $data['Photo4'] = $path . '/' . $filename;
        }
        $result = $this->user->editCookMeal($data);
        return $result->send();


    }
    public function getcookerinfo(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->getcookerinfo($data);
        return $result->send();


    }
    public function checkKitchenName(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',
            'Kitchen_Name' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->checkKitchenName($data);
        return $result->send();


    }
    public function uploadphoto(Request $request)
    {
        $rules = [
            'ApiToken'=>'required',
            'ApiKey' => 'required',
            'Photo' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        // $data = $request->all();
        $data = $request->except('Photo');

        if ($request->hasFile('Photo')) {

            $file = $request->file("Photo");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/UserPhotos';
            $file->move($path, $filename);
            $data['Photo'] = $path . '/' . $filename;
        }
        $result = $this->user->uploadphoto($data);
        return $result->send();


    }

    //-------------------------User-----------------
    public function UserSignUp(Request $request)
    {
        $rules = [
            'Email' => 'required|unique:users',
            'UserName' => 'required',
            'Phone' => 'required',
            'Password' => 'required',
            'Nationality' => 'required',
            'Late' => 'required',
            'Long' => 'required',
            'Area' => 'required',
            'City' => 'required',
            'Country' => 'required',
            'National_ID' => 'required',
            'Bank_Account' => 'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $api_key = env('APP_KEY');
        if ($api_key != $request->ApiKey) {
            return $this->apiResponse->setError("Unauthorized!")->send();
        }

        $data = $request->all();
        $result = $this->user->UserSignUp($data);
        return $result->send();

    }

    public function UserSignIn(Request $request)
    {
        $rules = [
            'Email' => 'required',
            'Password' => 'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $api_key = env('APP_KEY');
        if ($api_key != $request->ApiKey) {
            return $this->apiResponse->setError("Unauthorized!")->send();
        }

        $data = $request->all();
        $result = $this->user->UserSignIn($data);
        return $result->send();


    }
    public function getHome(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'key' =>'',
            'KitchenType_id'=>'',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->getHome($data);
        return $result->send();
    }
    public function searchmeal(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Key' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->searchmeal($data);
        return $result->send();

    }
    public function getallmealsofone(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Cooker_id' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->getallmealsofone($data);
        return $result->send();
    }
    public function getallnotifs(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->getallnotifs($data);
        return $result->send();

    }
    public function filter(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',




        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->filter($data);
        return $result->send();

    }
    public function getMealsOFKitchenType(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'KitchenType_id' =>'required',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->getMealsOFKitchenType($data);
        return $result->send();
    }

    public function getMealById(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Meal_id' =>'required',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->getMealById($data);
        return $result->send();

    }
    public function getallMealsOfCooker(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Cooker_id' =>'required',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->getallMealsOfCooker($data);
        return $result->send();
    }
    public function addmealtocart(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Meal_id' =>'required',
            'Quantity' =>'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->addmealtocart($data);
        return $result->send();
    }
    public function deletemealfromocart(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Meal_id' =>'required',

        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->deletemealfromocart($data);
        return $result->send();
    }
    public function emptyCart(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->emptyCart($data);
        return $result->send();
    }
    public function getCart(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->getCart($data);
        return $result->send();
    }

    public function checkCobon(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Code' =>'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->checkCobon($data);
        return $result->send();

    }
    public function addOrder(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->addOrder($data);
        return $result->send();

    }

    public function changephoto(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Photo' => 'required',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        // $data = $request->all();
        $data = $request->except('Photo');

        if ($request->hasFile('Photo')) {

            $file = $request->file("Photo");
            $filename = str_random(6) . '_' . time() . '_' . $file->getClientOriginalName();
            $path = 'ProjectFiles/UserPhotos';
            $file->move($path, $filename);
            $data['Photo'] = $path . '/' . $filename;
        }
        $result = $this->user->changephoto($data);
        return $result->send();

    }
    public function changeUserName(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'UserName' => 'required',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $data = $request->all();
        $result = $this->user->changeUserName($data);
        return $result->send();

    }
    public function changeEmail(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Email' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $data = $request->all();
        $result = $this->user->changeEmail($data);
        return $result->send();

    }
    public function changePhone(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Phone' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $data = $request->all();
        $result = $this->user->changePhone($data);
        return $result->send();

    }
    public function addNewAddresse(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Late' => 'required',
            'Long' => 'required',
            'Area' => 'required',
            'City' => 'required',
            'Country' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $data = $request->all();
        $result = $this->user->addNewAddresse($data);
        return $result->send();
    }
    public function updateFcm(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Token' => 'required',

        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $result = $this->user->updateFcm($request->all());
        return $result->send();
    }
    public function getGuestHome(Request $request)
    {
        $rules = [

            'ApiKey' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);
        $api_key = env('APP_KEY');
        if ($api_key != $request->ApiKey) {
            return $this->apiResponse->setError("Unauthorized!")->send();
        }
        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }
        $result = $this->user->getGuestHome($request->all());
        return $result->send();

    }
    public function filterByKitchenType(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'KitchenType_id' =>'required',



        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->filterByKitchenType($data);
        return $result->send();
    }
    public function filterByLargestRate(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',

        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->filterByLargestRate($data);
        return $result->send();
    }
    public function addCookerRate(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'Cooker_id' => 'required',
            'Rate' => 'required',
            // 'CookerMeal_id' => '',
            'Reason' => '',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->addCookerRate($data);
        return $result->send();
    }
    public function changeDefaultAddress(Request $request)
    {
        $rules = [
            'ApiToken' => 'required',
            'ApiKey' => 'required',
            'address_id' => 'required',


        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->apiResponse->setError($validation->errors()->first())->send();

        }

        $data = $request->all();
        $result = $this->user->changeDefaultAddress($data);
        return $result->send();
    }

}
