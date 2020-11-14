<?php

namespace App\Interfaces;

interface UserInterface
{
    public function welcome();
    public function CookerSignUp($data);
    public function CookerSignIn($data);
    public function getCookerMeals($data);
    public function addCookMeal($data);
    public function getAllKitchenTypes($data);
    public function updateProfile1($data);
    public function updateProfile2($data);
    public function changeOnlineStatus($data);
    // public function TestDistance($data);
    public function getAllNotifications($data);
    public function changeAvailableNotification($data);
    public function editCookMeal($data);
    public function getcookerinfo($data);
    public function checkKitchenName($data);
    public function verifyemail($id);
    public function uploadphoto($data);

    //------------User-------------------

    public function UserSignUp($data);
    public function UserSignIn($data);
    public function getHome($data);
    public function searchmeal($data);
    public function getallmealsofone($data);
    public function getallnotifs($data);
    public function filter($data);
    public function getMealsOFKitchenType($data);
    public function getMealById($data);
    public function getallMealsOfCooker($data);
    public function addmealtocart($data);
    public function deletemealfromocart($data);
    public function emptyCart($data);
    public function getCart($data);
    public function checkCobon($data);
    public function addOrder($data);
    public function changephoto($data);
    public function changeUserName($data);
    public function changeEmail($data);
    public function changePhone($data);
    public function addNewAddresse($data);
    public function updateFcm($data);
    public function getGuestHome($data);
    public function filterByKitchenType($data);
    public function filterByLargestRate($data);
    public function addCookerRate($data);
    public function changeDefaultAddress($data);

    





}
