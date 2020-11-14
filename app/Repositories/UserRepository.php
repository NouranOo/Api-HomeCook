<?php
namespace App\Repositories;
use Pnlinh\GoogleDistance\Facades\GoogleDistance;
use App\Interfaces\UserInterface;
use App\Helpers\FCMHelper;
use App\Helpers\ApiResponse;
use App\Helpers\GeneralHelper;
use  App\Http\Resources\UserResource;
use  App\Http\Resources\MealResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cooker_Meal;
use App\Models\Notfication;
use App\Models\Order;
use DB;
use App\Models\Cobon;
use App\Models\Cooker_rate;
use App\Models\user_address;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\KitchenType;
use App\Models\Meal_Photo;
use App\Models\Rate;
use App\Models\cooker_kitchentype;

use Illuminate\Support\Facades\Hash;
use function foo\func;

class UserRepository implements UserInterface
{

    public $apiResponse;
    public $generalhelper;

    public function __construct(GeneralHelper $generalhelper, ApiResponse $apiResponse){
        $this->generalhelper = $generalhelper;

        $this->apiResponse = $apiResponse;


    }

    public function welcome(){
        return "Hello";
    }
    public function verifyemail($id){

        $user = User::where('id',$id)->first();
        $user->IsVerified = 1;
        $user->save();
        return $this->apiResponse->setSuccess("Thanks For Using Home Cook App ");

    }
    public function CookerSignUp($data){

        try{
            $data['ApiToken'] = base64_encode(str_random(40));
            $data['Password'] = app('hash')->make($data['Password']);
            $user = new User();
            $user->Name = $data['Name'];
            $user->Kitchen_Name = $data['Kitchen_Name'];
            $user->Phone = $data['Phone'];
            $user->Password = $data['Password'];
            $user->Nationality = $data['Nationality'];
            $user->Late = $data['Late'];
            $user->Long = $data['Long'];
            $user->Area = $data['Area'];
            $user->City = $data['City'];
            $user->Country = $data['Country'];
            $user->National_ID = $data['National_ID'];
            $user->Bank_Account = $data['Bank_Account'];
            $user->IsConfirmed = 0;
            $user->ApiToken = $data['ApiToken'];
            $user->UserType = "Cooker";
            $user->save();
            // GeneralHelper::testSendGrid($user);


            $newUSer = User::where('id',$user->id)->first();
            // dd("Right");


        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Cooker created succesfully")->setData($newUSer);

    }
    public function CookerSignIn($data)
    {
        try{
            $user = User::where('Phone',$data['Phone'])->first();
            if($user){
                $check = Hash::check($data['Password'], $user->Password);
                if ($check) {
                    if($user->IsConfirmed = 1){

                        $user->update(['ApiToken' => base64_encode(str_random(40))]);
                        $user->save();
                    }else{
                        return $this->apiResponse->setError("Your Phone Not Confirmed")->setData();
                    }
                }else{
                    return $this->apiResponse->setError("Your Password Not correct")->setData();
                }

            }else{
                return $this->apiResponse->setError("Your Phone Not Found")->setData();
            }


        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Login succesfully")->setData($user);


    }

    public function getCookerMeals($data)
    {
        try{
            $cooker = GeneralHelper::getcurrentUser();

            $cookerMeals = Cooker_Meal::where('Cooker_id',$cooker->id)->with(['KitchenType'])->paginate(10);
            // foreach($cookerMeals as $cookMeal){
            //     $rates = Rate::where('CookerMeal_id',$cookMeal->id)->avg('Rate');
            //     $countRates = Rate::where('CookerMeal_id',$cookMeal->id)->count();
            //     $cookMeal->forcefill(['Rate'=>$rates,'PeopleRates'=>$countRates]);
            //     $rates->avg('Rate');
            //     dd($rates,$countRates);
            // }


        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("fetch Meals succesfully")->setData($cookerMeals);

    }
    public function addCookMeal($data)
    {
        try{
            // dd($data);
            $cooker = GeneralHelper::getcurrentUser();
            // dd($cooker);
            $cookerMeal = new Cooker_Meal();
            $cookerMeal->Cooker_id = $cooker->id;
            if($data['Title_en']){
                $cookerMeal->Title_en =$data['Title_en'] ;
            }
            if($data['Title_ar']){
                $cookerMeal->Title_ar = $data['Title_ar'] ;
            }
            if($data['Description_en']){
                $cookerMeal->Description_en = $data['Description_en'];
            }
            if($data['Description_ar']){
                $cookerMeal->Description_ar = $data['Description_ar'];
            }
            // if($data['Ingredients_en']){
            //     $cookerMeal->Ingredients_en = $data['Ingredients_en'];
            // }
            // if($data['Ingredients_ar']){
            //     $cookerMeal->Ingredients_ar = $data['Ingredients_ar'];
            // }
            if(!empty($data['KitchenType_id'])){

                $cookerMeal->KitchenType_id = $data['KitchenType_id'];
            }
            if(!empty($data['Price'])){

                $cookerMeal->Price = $data['Price'];
            }
            if(!empty($data['Expected_time'] )){

                $cookerMeal->Expected_time = $data['Expected_time'] ;
            }
            if(!empty($data['Saturday'])){
                $cookerMeal->Saturday=$data['Saturday'];
            }
            if(!empty($data['Sunday'])){
                $cookerMeal->Sunday=$data['Sunday'];
            }
            if(!empty($data['Monday'])){
                $cookerMeal->Monday=$data['Monday'];
            }
            if(!empty($data['Tuesday'])){
                $cookerMeal->Tuesday=$data['Tuesday'];
            }
            if(!empty($data['Wednesday'])){
                $cookerMeal->Wednesday=$data['Wednesday'];
            }
            if(!empty($data['Thursday'])){
                $cookerMeal->Thursday=$data['Thursday'];
            }
            if(!empty($data['Friday'])){
                $cookerMeal->Friday=$data['Friday'];
            }
            if(!empty($data['Photo1'])){

                $cookerMeal->Photo1 = $data['Photo1'];
            }
            // dd( $cookerMeal->Photo1);
            if(!empty($data['Photo2'] )){
                $cookerMeal->Photo2 = $data['Photo2'];
            }
            if(!empty($data['Photo3']) ){
                $cookerMeal->Photo3 = $data['Photo3'];
            }
            if(!empty($data['Photo4'] )){
                $cookerMeal->Photo4 = $data['Photo4'];
            }
            $cookerMeal->save();


            //Add- KitchenTypes to Cooker

            $cooker_kitchentype = new cooker_kitchentype();
            $cooker_kitchentype->Cooker_id = $cooker->id;
            $cooker_kitchentype->KitchenType_id = $data['KitchenType_id'];
            $cooker_kitchentype->save();

            $newcookerMeal = Cooker_Meal::where('id',$cookerMeal->id)->first();
            // $Meal_Photo = new Meal_Photo();
            // $Meal_Photo->CookerMeal_id = $cookerMeal->id;
            // $Meal_Photo->Photo=$data['Photo1'];
            // if(!empty($data['Photo1'])){
            //     // dd($cookerMeal->id);
            //     $Meal_Photo->CookerMeal_id = $cookerMeal->id;
            //     $Meal_Photo->Photo=$data['Photo1'];
            //     // $Meal_Photo->save();

            // }
            // if(!empty($data['Photo2'] )){
            //     // dd($cookerMeal->id);
            //     $Meal_Photo->CookerMeal_id = $cookerMeal->id;
            //     $Meal_Photo->Photo=$data['Photo2'];
            //     // $Meal_Photo->save();
            // }
            // if(!empty($data['Photo3']) ){
            //     // dd($cookerMeal->id);

            //     $Meal_Photo->CookerMeal_id = $cookerMeal->id;
            //     $Meal_Photo->Photo=$data['Photo3'];
            //     // $Meal_Photo->save();
            // }
            // if(!empty($data['Photo4'] )){
            //     // dd($cookerMeal->id,$data['Photo4'] );

            //     $Meal_Photo->CookerMeal_id = $cookerMeal->id;
            //     $Meal_Photo->Photo=$data['Photo4'];
            //     // $Meal_Photo->save();
            // }
            // dd($Meal_Photo);
            // $Meal_Photo->save();






        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("Added Meal succesfully")->setData($newcookerMeal);



    }
    public function getAllKitchenTypes($data)
    {
        try{
            $KitchenTypes = KitchenType::all();

        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("Fetch KitchenTypes succesfully")->setData($KitchenTypes);


    }
    public function updateProfile1($data)
    {
        try{
            $cooker = GeneralHelper::getcurrentUser();
            if(!empty($data['Photo'])){
                $cooker->Photo = $data['Photo'];
            }
            if(!empty($data['Name'])){
                $cooker->Name = $data['Name'];
            }
            if(!empty($data['Kitchen_Name'])){
                $cooker->Kitchen_Name = $data['Kitchen_Name'];
            }
            if(!empty($data['Nationality'])){
                $cooker->Nationality = $data['Nationality'];
            }
            $cooker->save();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("Updated profile succesfully")->setData($cooker);


    }
    public function updateProfile2($data)
    {
        try{
            $cooker = GeneralHelper::getcurrentUser();
            if(!empty($data['Late'])){
                $cooker->Late = $data['Late'];
            }
            if(!empty($data['Long'])){
                $cooker->Long = $data['Long'];
            }
            if(!empty($data['Phone'])){
                $cooker->Phone = $data['Phone'];
            }
            if(!empty($data['National_ID'])){
                $cooker->National_ID = $data['National_ID'];
            }
            if(!empty($data['Bank_Account'])){
                $cooker->Bank_Account = $data['Bank_Account'];
            }
            $cooker->save();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("Updated profile succesfully")->setData($cooker);


    }
    public function changeOnlineStatus($data)
    {
        try{
            $cooker = GeneralHelper::getcurrentUser();
            $cooker->IsAvailable = $data['Online'];
            $cooker->save();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("Changed  succesfully")->setData($cooker);


    }
    // public function TestDistance($data)
    // {
    //     // $user1 = User::where('id',1)->get('Late');
    //     // $user2 = User::where('id',2)->get('Late');

    //     // $distance = GoogleDistance::calculate( $user1, $user2);

    //     // // Use Helper Function
    //     // $distance = google_distance( $user1, $user2);
    //     return $this->apiResponse->setSuccess("Changed  succesfully")->setData($cooker);

    // }
    public function getAllNotifications($data)
    {
        try{
            $cooker = GeneralHelper::getcurrentUser();
            $Nots = Notfication::where('notify_target_id',$cooker->id)->get();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("Fetched Notifications succesfully")->setData($Nots);


    }
    public function changeAvailableNotification($data)
    {
        try{
            $cooker = GeneralHelper::getcurrentUser();
            $cooker->AvailableNotification=1;
            $cooker->save();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("Changed Status succesfully")->setData($cooker);


    }
    public function editCookMeal($data)
    {
        try{
            // dd($data);
            $cooker = GeneralHelper::getcurrentUser();
            // dd($cooker);
            $cookerMeal = Cooker_Meal::where('id',$data['CookMeal_id'])->first();

            if($data['Title_en']){
                $cookerMeal->Title_en =$data['Title_en'] ;
            }
            if($data['Title_ar']){
                $cookerMeal->Title_ar = $data['Title_ar'] ;
            }
            if($data['Description_en']){
                $cookerMeal->Description_en = $data['Description_en'];
            }
            if($data['Description_ar']){
                $cookerMeal->Description_ar = $data['Description_ar'];
            }
            // if($data['Ingredients_en']){
            //     $cookerMeal->Ingredients_en = $data['Ingredients_en'];
            // }
            // if($data['Ingredients_ar']){
            //     $cookerMeal->Ingredients_ar = $data['Ingredients_ar'];
            // }
            if($data['KitchenType_id']){
                $cookerMeal->KitchenType_id = $data['KitchenType_id'];
            }
            if($data['Price']){
                $cookerMeal->Price = $data['Price'];
            }
            if($data['Expected_time'] ){
                $cookerMeal->Expected_time = $data['Expected_time'] ;
            }

            if($data['Saturday']){
                $cookerMeal->Saturday=$data['Saturday'];
            }
            if($data['Sunday']){
                $cookerMeal->Sunday=$data['Sunday'];
            }
            if($data['Monday']){
                $cookerMeal->Monday=$data['Monday'];
            }
            if($data['Tuesday']){
                $cookerMeal->Tuesday=$data['Tuesday'];
            }
            if($data['Wednesday']){
                $cookerMeal->Wednesday=$data['Wednesday'];
            }
            if($data['Thursday']){
                $cookerMeal->Thursday=$data['Thursday'];
            }
            if($data['Friday']){
                $cookerMeal->Friday=$data['Friday'];
            }
            if(!empty($data['Photo1'] )){
                $cookerMeal->Photo1 = $data['Photo1'];
            }

            if(!empty($data['Photo2'] )){
                $cookerMeal->Photo2 = $data['Photo2'];
            }
            if(!empty($data['Photo3']) ){
                $cookerMeal->Photo3 = $data['Photo3'];
            }
            if(!empty($data['Photo4'] )){
                $cookerMeal->Photo4 = $data['Photo4'];
            }
            $cookerMeal->save();
            $newcookerMeal = Cooker_Meal::where('id',$cookerMeal->id)->first();


        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }

        return $this->apiResponse->setSuccess("Edited  Meal succesfully")->setData($newcookerMeal);



    }
    public function getcookerinfo($data){
        try{
            $user = User::where('ApiToken',$data['ApiToken'])->first();

        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Get info succesfully")->setData($user);
    }
    public function checkKitchenName($data){
        try{
            $user = User::where('ApiToken',$data['ApiToken'])->first();
            if( $user->Kitchen_Name == $data['Kitchen_Name']){
                // dd("Right");
                return $this->apiResponse->setSuccess("KitchenName Found");
            }else{
                return $this->apiResponse->setError("KitchenName NotFound");
            }

        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }

    }
    public function uploadphoto($data)
    {
        try{
            $cooker = GeneralHelper::getcurrentUser();
            $cooker->Photo =  $data['Photo'];
            $cooker->save();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Photot updated successfully")->setData($cooker);


    }

    //---------------------User----------------------
    public function UserSignUp($data)
    {
        try{
            $data['ApiToken'] = base64_encode(str_random(40));
            // $data['VerifyCode'] = base64_encode(str_random(6));
            $data['Password'] = app('hash')->make($data['Password']);
            $data['VerifyCode'] = base64_encode(str_random(6));
            $user = new User();
            $user->Email = $data['Email'];
            $user->UserName = $data['UserName'];
            $user->Phone = $data['Phone'];
            $user->Password = $data['Password'];
            $user->Nationality = $data['Nationality'];
            $user->Late = $data['Late'];
            $user->Long = $data['Long'];
            $user->Area = $data['Area'];
            $user->City = $data['City'];
            $user->Country = $data['Country'];
            $user->National_ID = $data['National_ID'];
            $user->Bank_Account = $data['Bank_Account'];
            $user->VerifyCode = $data['VerifyCode'];
            // $user->VerifyCode = $data['VerifyCode'];
            $user->IsVerified = 0;
            $user->ApiToken = $data['ApiToken'];
            $user->UserType = "User";
            $user->save();
            //cart
            $cart = new Cart();
            $cart->User_id = $user->id;
            $cart->save();
            //add address
            $user_address = new user_address();
            $user_address->user_id = $user->id;
            $user_address->lat = $data['Late'];
            $user_address->lng = $data['Long'];
            $user_address->area = $data['Area'];
            $user_address->city = $data['City'];
            $user_address->country =$data['Country'];
            $user_address->save();
            $newUSer = User::where('id',$user->id)->first();


        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data" , $ex)->setData();
        }
        $verify = GeneralHelper::verifyEmail($user);
        return $this->apiResponse->setSuccess("User created succesfully")->setData($newUSer);

    }
    public function UserSignIn($data)
    {
        try{
            $user = User::where('Email',$data['Email'])->first();
            if($user){
                $check = Hash::check($data['Password'], $user->Password);
                if ($check) {
                    if($user->IsVerified = 1){

                        $user->update(['ApiToken' => base64_encode(str_random(40))]);
                        $user->save();
                    }else{
                        return $this->apiResponse->setError("Your Email Not Verified")->setData();
                    }
                }else{
                    return $this->apiResponse->setError("Your Password Not correct")->setData();
                }

            }else{
                return $this->apiResponse->setError("Your Email Not Found")->setData();
            }


        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Login succesfully")->setData($user);


    }
    public function getHome($data)
    {
        try{
            $arr = array();
            $user = GeneralHelper::getcurrentUser();

            $cookers = User::where('UserType','Cooker')->with(['cookerRating','kitchen_types'])->paginate(10);
            $resource1 = UserResource::collection($cookers);





            if($data['key']){
                switch($data['key']) {
                    //1-kitchen_type_id
                    case 1 :
                        //filtered by $data['KitchenType_id']
                        $cooker_ids = cooker_kitchentype::where('KitchenType_id',$data['KitchenType_id'])->pluck('Cooker_id')->toArray();
                        $cookers_after_filtered = User::whereIn('id',$cooker_ids)->paginate(10);

                        $filtered = UserResource::collection($cookers_after_filtered);

                        return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($filtered);

                        break;
                    //2-Nearest Place
                    case 2 :
                        $arr = array();
                        $lat = $user->Late;
                        $long = $user->Long;
                        $cookers = User::select("users.*"
                            , DB::raw("6371 * acos(cos(radians(" . $lat . "))
                                * cos(radians(users.Late))
                                * cos(radians(users.Long) - radians(" . $long . "))
                                + sin(radians(" . $lat . "))
                                * sin(radians(users.Late))) AS distance"))
                            ->groupBy("users.id")
                            ->with(['cookerRating','kitchen_types'])
                            ->paginate(10);

                        $resource = UserResource::collection($cookers);
                        return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($resource);
                        break;
                    case 3 :
                        //-----Kitchen_type && Nearest------
                        $cooker_ids = cooker_kitchentype::where('KitchenType_id',$data['KitchenType_id'])->pluck('Cooker_id')->toArray();
                        $cookers_after_kitchentype = User::whereIn('id',$cooker_ids)->get();
                        //-------------Nearest Place-----------------------
                        $lat = $user->Late;
                        $long = $user->Long;
                        $cookers_after_nearest = User::select("users.*"
                            , DB::raw("6371 * acos(cos(radians(" . $lat . "))
                                    * cos(radians(users.Late))
                                    * cos(radians(users.Long) - radians(" . $long . "))
                                    + sin(radians(" . $lat . "))
                                    * sin(radians(users.Late))) AS distance"))
                            ->groupBy("users.id")
                            ->with(['cookerRating','kitchen_types'])
                            ->paginate(10);
                        $merged = $cookers_after_kitchentype->merge($cookers_after_nearest);

                        $resource = UserResource::collection($merged);
                        return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($resource);
                        break;
                    case 4 :
                        //-------- Desc Rate--------
                        $cookers = User::where('UserType','Cooker')->paginate(10);
                        $filtered_cookers=$cookers->sortByDesc('rate');
                        $resource = UserResource::collection($filtered_cookers);

                        return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($resource);

                        break;
                    case 5 :
                        //------Kitchen_type && Desc Rate----------
                        $cooker_ids = cooker_kitchentype::where('KitchenType_id',$data['KitchenType_id'])->pluck('Cooker_id')->toArray();
                        $cookers_after_kitchentype = User::whereIn('id',$cooker_ids)->paginate(10);
                        $filtered_cookers =$cookers_after_kitchentype->sortByDesc('rate');
                        $resource = UserResource::collection($filtered_cookers);
                        return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($resource);
                        break;
                    default:
                        $cookers = User::where('UserType','Cooker')->pginate(10);
                        return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($cookers);
                        break;

                }

            }

        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($cookers);

    }
    public function searchmeal($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $meals = Cooker_Meal::where('Title_en', 'like', '%' . $data['Key'] . '%')
                ->orwhere('Title_ar', 'like', '%' . $data['Key'] . '%')
                ->orwhere('Description_en', 'like', '%' . $data['Key'] . '%')
                ->orwhere('Description_ar', 'like', '%' . $data['Key'] . '%')->get();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Fetch Meals succesfully")->setData($meals);


    }
    public function getallmealsofone($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $meals = Cooker_Meal::where('Cooker_id',$data['Cooker_id'])->paginate(5);
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Fetch Meals succesfully")->setData($meals);


    }
    public function getallnotifs($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $notifs = Notfication::where('notify_target_id',$user->id)->get();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Fetch Notififcations succesfully")->setData($notifs);


    }


    public function filter($data)
    {

        try{
            $user = GeneralHelper::getcurrentUser();

            $lat = $user->Late;
            $long = $user->Long;
            $Cookers=DB::table("users")
                ->select("users.*"
                    ,DB::raw("6371 * acos(cos(radians(" . $lat . "))
                * cos(radians(users.Late))
                * cos(radians(users.Long) - radians(" . $long . "))
                + sin(radians(" .$lat. "))
                * sin(radians(users.Late))) AS distance"))
                ->groupBy("users.id")
                ->paginate(4);
            return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($Cookers);
//            $key = $data['key'];
//            switch($key){
//                //1-Nearest places
//                case 1 :
//                // dd("aa");
//                    $lat = $user->Late;
//                    $long = $user->Long;
//                    $Cookers=DB::table("users")
//                        ->select("users.*"
//                        ,DB::raw("6371 * acos(cos(radians(" . $lat . "))
//                        * cos(radians(users.Late))
//                        * cos(radians(users.Long) - radians(" . $long . "))
//                        + sin(radians(" .$lat. "))
//                        * sin(radians(users.Late))) AS distance"))
//                        ->groupBy("users.id")
//                        ->paginate(4);
//                        return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($Cookers);
//
//
//                break;

//                case 2 :
//                    $recommendedCooker = User::where('UserType','Cooker')->where('IsConfirmed',1)->inRandomOrder()->take(5)->get();
//                    return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($recommendedCooker);
//                break;
//                case 3:
//                    $arr=[];
//                    $orders = DB::table('orders')
//                    ->select(DB::raw('id ,Cooker_id, count(`id`) as count'))
//                    ->groupBy('Cooker_id')
//                    ->orderBy('count','Desc')
//                    ->get();
//                    // dd($orders);
//
//                    foreach($orders as $order){
//                        // $x=Order::where('id',$order->id)->with('Cooker')->first();
//                        $cooker=User::where('id',$order->Cooker_id)->first();
//                        array_push($arr, $cooker);
//
//                    }
//
//
//                    return $this->apiResponse->setSuccess("Fetch Home succesfully")->setData($arr);
//
//
//
//                break;
//
//                default:
//
//                    return $this->apiResponse->setError("Choose from 1-3");
//                break;

//            }
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }

    }
    public function getMealsOFKitchenType($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $Cooker_Meals = Cooker_Meal::where('KitchenType_id',$data['KitchenType_id'])->get();
            // foreach($Cooker_Meals as $cookMeal){
            //     $rates = Rate::where('CookerMeal_id',$cookMeal->id)->avg('Rate');
            //     $countRates = Rate::where('CookerMeal_id',$cookMeal->id)->count();
            //     $cookMeal->forcefill(['Rate'=>$rates,'PeopleRates'=>$countRates]);
            //     $rates->avg('Rate');
            //     dd($rates,$countRates);
            // }
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Fetch Meals succesfully")->setData($Cooker_Meals );


    }
    public function getMealById($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $Cooker_Meal = Cooker_Meal::where('id',$data['Meal_id'])->with(['Cooker','KitchenType'])->first();

            // $rates = Rate::where('CookerMeal_id',$Cooker_Meal->id)->avg('Rate');
            // $countRates = Rate::where('CookerMeal_id',$Cooker_Meal->id)->count();
            // $Cooker_Meal->forcefill(['Rate'=>$rates,'PeopleRates'=>$countRates]);
            $isAddToCart = CartItem::where('Meal_id',$Cooker_Meal->id)->where('User_id',$user->id)->first();
            if($isAddToCart){
                $Cooker_Meal->forcefill(['IsAddToCart'=>true]);

            }else{
                $Cooker_Meal->forcefill(['IsAddToCart'=>false]);
            }


        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Fetch Meal succesfully")->setData($Cooker_Meal );
    }
    public function getallMealsOfCooker($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $Cooker_Meals = Cooker_Meal::where('Cooker_id',$data['Cooker_id'])->with('KitchenType')->with(['Cooker'=>function($query){
                $query->with('cookerRating');
            }])->paginate(10);
           $result = MealResource::collection($Cooker_Meals);

        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Fetch Meals succesfully")->setData($Cooker_Meals );


    }
    public function addmealtocart($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $cart = Cart::where('User_id',$user->id)->first();
            $isfound = CartItem::where('User_id',$user->id)->where('Cart_id',$cart->id)->where('Meal_id',$data['Meal_id'])->first();
            if($isfound){
                // dd("jj");
                $isfound->update(['Quantity'=>$data['Quantity']]);
                return $this->apiResponse->setSuccess("Changed Meal succesfully")->setData($isfound );
            }else{
                $cartItem = new CartItem();
                $cartItem->User_id = $user->id;
                $cartItem->Meal_id = $data['Meal_id'];
                $cartItem->Cart_id = $cart->id;
                $cartItem->Quantity = $data['Quantity'];
                $cartItem->save();

                return $this->apiResponse->setSuccess("Added Meal to cart succesfully")->setData($cartItem );
            }


            // dd( $cartID );/
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }



    }
    public function deletemealfromocart($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $cart = Cart::where('User_id',$user->id)->first();
            $isfound = CartItem::where('User_id',$user->id)->where('Cart_id',$cart->id)->where('Meal_id',$data['Meal_id'])->first();
            if($isfound){
                // dd("jj");
                $isfound->delete();
                return $this->apiResponse->setSuccess("Deleted Meal from cart succesfully")->setData();
            }else{


                return $this->apiResponse->setError("Meal not found in cart ")->setData();
            }


            // dd( $cartID );/
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
    }
    public function emptyCart($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $cart = Cart::where('User_id',$user->id)->first();
            $Items = CartItem::where('User_id',$user->id)->where('Cart_id',$cart->id)->get();
            if($Items){
                foreach($Items as $item){
                    $item->delete();
                }

                return $this->apiResponse->setSuccess("Deleted Meal from cart succesfully")->setData();
            }else{


                return $this->apiResponse->setError("Cart is empty ")->setData();
            }

        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }


    }
    public function getCart($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $cart = Cart::where('User_id',$user->id)->first();
            $Items = CartItem::where('User_id',$user->id)->where('Cart_id',$cart->id)->with('Meal')->get();
            ///----------مصاريف الشخن ؟
            return $this->apiResponse->setSuccess("Fetch Cart successfuly")->setData($Items);
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }


    }
    public function checkCobon($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $cobon = Cobon::where('Code',$data['Code'])->first();
            if($cobon){
                if($cobon->isAvailable == 1){

                    return $this->apiResponse->setSuccess("This Cobon Available")->setData($cobon);
                }else{

                    return $this->apiResponse->setError("This Cobon not Available")->setData();
                }
            }else{
                return $this->apiResponse->setError("This Cobon not found")->setData();

            }
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }


    }
    public function addOrder($data)
    {

    }
    public function changephoto($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $user->Photo =  $data['Photo'];
            $user->save();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Photot updated successfully")->setData($user);
    }
    public function changeUserName($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $user->UserName =  $data['UserName'];
            $user->save();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("UserName changed successfully")->setData($user);

    }
    public function changeEmail($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $user->Email =  $data['Email'];
            $user->save();
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Email changed successfully")->setData($user);

    }
    public function changePhone($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $user->Phone =  $data['Phone'];
            $user->save();
            //--------------------------FireBaseNotfication------------------------------------------
            $TargetUser = User::where('id', $user->id)->first();
            $data1 = array('tit le' => 'HomeCook', 'body' => 'Test' . ' ' . 'changed phone', 'Key' => 'Notify');
            $res = FCMHelper::sendFCMMessage($data1, $TargetUser->Token);
            //---------------------------------------------------------------------
        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Phone changed successfully")->setData($user);

    }
    public function addNewAddresse($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $user_address = new user_address();
            $user_address->user_id = $user->id;
            $user_address->lat = $data['Late'];
            $user_address->lng = $data['Long'];
            $user_address->area = $data['Area'];
            $user_address->city = $data['City'];
            $user_address->country =$data['Country'];
            $user_address->save();


        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Address added successfully")->setData($user_address);

    }

    public function updateFcm($data)
    {
        $user = User::where('ApiToken',$data['ApiToken'])->first();
        $user->Token = $data['Token'];
        $user->save();
        return $this->apiResponse->setSuccess("fcm updated successfully")->setData($user);

    }
    public function getGuestHome($data)
    {

        $recommendedCooker = User::where('UserType','Cooker')->where('IsConfirmed',1)->inRandomOrder()->take(15)->get();
        return $this->apiResponse->setSuccess("Fetced Cookers successfully")->setData($recommendedCooker);

    }
    public function filterByKitchenType($data)
    {
        $cookers = [];
        $CookersIds = Cooker_Meal::where('KitchenType_id',$data['KitchenType_id'])->get('Cooker_id');
        $collection = collect($CookersIds);

        $unique_data = $collection->unique()->values()->all();
        foreach ($unique_data as $id)
        {

            $cooker = User::where('id',$id->Cooker_id)->first();
            array_push($cookers,$cooker);
        }

        return $this->apiResponse->setSuccess("Fetced Cookers successfully")->setData($cookers);
    }
    public function filterByLargestRate($data)
    {
        $cookers = [];
        $CookersIds = Rate::orderBy('Rate','desc')->get('Cooker_id');
        $collection = collect($CookersIds);
        $unique_data = $collection->unique()->values()->all();

        foreach ($unique_data as $id)
        {

            $cooker = User::where('id',$id->Cooker_id)->first();
            array_push($cookers,$cooker);
        }
        return $this->apiResponse->setSuccess("Fetced Cookers successfully")->setData($cookers);
    }
    public function addCookerRate($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $rate = new Rate();
            $rate->User_id =$user->id;
            $rate->Cooker_id = $data['Cooker_id'];
            // if(!empty($data['CookerMeal_id'])){

            //     $rate->CookerMeal_id = $data['CookerMeal_id'];
            // }
            $rate->Rate = $data['Rate'];
            if(!empty($data['Reason'])){

                $rate->Reason = $data['Reason'];
            }
            $rate->save();

        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Address changed successfully")->setData($rate);

    }
    public function changeDefaultAddress($data)
    {
        try{
            $user = GeneralHelper::getcurrentUser();
            $user_address = user_address::where('id',$data['address_id'])->first();
            $user->Late = $user_address->lat;
            $user->Long = $user_address->lng;
            $user->Area = $user_address->area;
            $user->City = $user_address->city;
            $user->Country  = $user_address->country;
            $user->save();

        }catch(Exception $ex){
            return $this->apiResponse->setError("Missing Data", $ex)->setData();
        }
        return $this->apiResponse->setSuccess("Changed default successfully")->setData($user);

    }

}
