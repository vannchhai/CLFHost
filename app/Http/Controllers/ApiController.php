<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Liker;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Message;
use App\Models\MainMessage;
use App\Models\Notification;
use App\Models\Location;
use App\Models\Feedback;
use App\Models\ItemCategory;
use App\Http\Controllers\FrontController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use LRedis;

class ApiController extends FrontController
{
    use AuthenticatesUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
        $app_id = $_GET['APP_ID'];
        if ($app_id != 'za0HOHo9qA1edryH6uEFZTj9thlR/jRuyy5hjIyjVnA=') {
            die();
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // $check = array('email' => $request->email, 'password' => Hash::check('secret', $request->password));
        // $request = json_decode($_GET['data']);
        // $data = User::where('email' , $request->email)->first();

        // return response()->json($data);
        $checkPass =  User::where('email', $request->email)->first();

        if (isset($checkPass)) {
             $isVerify = password_verify($request->password , $checkPass->password);

            if($isVerify){
                $data =  User::where('email', $request->email)->first();
                return response()->json($data);

            }
        }

        return response()->json([]);
    }

    public function signup(Request $request){
        $checkEmail = User::where('email',$request->email)->first();
        if ($checkEmail != '') {
              return response()->json("exist");
        }else{
            $arr = array(
                'name' => $request->name, 
                'email' => $request->email, 
                'phone' => $request->phone, 
                'sex' => 0, 
                'password' => password_hash($request->password, PASSWORD_BCRYPT), 
                'user_type_id' => 1,
                'icon' => 0,
                'closed' => 0,
                'block' => 0,
                'ip_address' => '000.000.000.000',
                'activation_token' => "",
                'active' => 1, 
                );
            $insert = new User($arr);
            $insert->save();
            return response()->json($insert);
        }
    }

    public function postItem(Request $request){
        try {
            $points = $request->marker;

            $arr = array( 
                'item_name' => $request->name, 
                'item_type_id' => $request->type, 
                'item_description' => $request->description,
                'item_category_id' => $request->category, 
                'contact_number' => $request->contact_number, 
                'user_id' => $request->user_id,
                'icon' => 0
                );
            $insertItem = new Item($arr);
            $insertItem->save();
            for ($i=0; $i < sizeof($points); $i++) { 
                $point = array(
                    'country_code' => 'KH', 
                    'location_name' => 'KH', 
                    'longitude' => $points[$i]['lng'], 
                    'latitude' => $points[$i]['lat'], 
                    'item_id' => $insertItem->id,
                    'active' => 'KH', 
                    );
                $insertLocation = new Location($point);
                $insertLocation->save();
            }

            if (!file_exists(public_path().'/assets/upload/user_'.$insertItem->user_id)) {
                mkdir(public_path().'/assets/upload/user_'.$insertItem->user_id, 0777, true);
            }

            $path = public_path().'/assets/upload/user_'.$insertItem->user_id."/".$insertItem->id.'.jpg';
            $data = $request->photo;
            $imgItm = file_put_contents($path,base64_decode($data));
            $destination = public_path().'/assets/upload/user_'.$insertItem->user_id.'/_thumnail/';

            $width = 400;
            $height = 400;

            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

           if (file_exists($path)) {
                // Get new dimensions
                list($width_orig, $height_orig) = getimagesize($path);

                $ratio_orig = $width_orig/$height_orig;

                if ($width/$height > $ratio_orig) {
                   $width = $height*$ratio_orig;
                } else {
                   $height = $width/$ratio_orig;
                }

                // Resample
                $image_p = imagecreatetruecolor($width, $height);
                // $image = imagecreatefromjpeg($path);


                $info = getimagesize($path);

                if ($info['mime'] == 'image/jpeg') 
                    $image = imagecreatefromjpeg($path);

                elseif ($info['mime'] == 'image/gif') 
                    $image = imagecreatefromgif($path);

                elseif ($info['mime'] == 'image/png') 
                    $image = imagecreatefrompng($path);


                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                $filename = $destination.$insertItem->id.'.jpg';
                // // Output
                imagejpeg($image_p, $filename, 100);
           }


            if ($imgItm != '') {
                $arrNew = array( 
                'item_name' => $request->name, 
                'item_type_id' => $request->type, 
                'item_description' => $request->description,
                'item_category_id' => $request->category, 
                'contact_number' => $request->contact_number, 
                'user_id' => $request->user_id, 
                'icon' => 1
                );
                Item::where('id', $insertItem->id)->update($arrNew);
            }
            return response()->json($insertItem);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function editProfile(Request $request){

        $img = $request->photo;

        $checkPass =  User::where('email', $request->email)->first();

        if (isset($checkPass)) {
             $isVerify = password_verify($request->current , $checkPass->password);

            if($isVerify){
                 if (isset($img)) {
                    if (!file_exists(public_path().'/assets/upload/user_'.$request->id)) {
                        mkdir(public_path().'/assets/upload/user_'.$request->id, 0777, true);
                    }

                    $path = public_path().'/assets/upload/user_'.$request->id."/profile-".$request->id.'.jpg';
                    file_put_contents($path, base64_decode($img));


                    $destination = public_path().'/assets/upload/user_'.$request->id.'/_thumnail/';

                    $width = 400;
                    $height = 400;

                    if (!file_exists($destination)) {
                        mkdir($destination, 0777, true);
                    }

                    if (file_exists($path)) {
                        // Get new dimensions
                        if(!list($width_orig, $height_orig) = getimagesize($path)) return "Unsupported picture type!";
                        
                        list($width_orig, $height_orig) = getimagesize($path);

                        $ratio_orig = $width_orig/$height_orig;

                        if ($width/$height > $ratio_orig) {
                           $width = $height*$ratio_orig;
                        } else {
                           $height = $width/$ratio_orig;
                        }

                        // Resample
                        $image_p = imagecreatetruecolor($width, $height);
                        // $image = imagecreatefromjpeg($path);


                        $info = getimagesize($path);

                        if ($info['mime'] == 'image/jpeg') 
                            $image = imagecreatefromjpeg($path);

                        elseif ($info['mime'] == 'image/gif') 
                            $image = imagecreatefromgif($path);

                        elseif ($info['mime'] == 'image/png') 
                            $image = imagecreatefrompng($path);


                        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                        $filename = $destination.'profile-'.$request->id.'.jpg';
                        // // Output
                        imagejpeg($image_p, $filename, 100);
                    }


                    $arrNew = array(
                    'id' => $request->id, 
                    'name' => $request->username, 
                    'email' => $request->email, 
                    'phone' => $request->phone, 
                    'sex' => $request->sex, 
                    'password' => password_hash($request->newpassword, PASSWORD_BCRYPT), 
                    'active' => 1, 
                    'profile' => 1
                    );
                    
                    $update = User::where('id', $request->id)->update($arrNew);
                    return response()->json($update);
                }else{
                     $arr = array(
                    'id' => $request->id, 
                    'name' => $request->username, 
                    'email' => $request->email, 
                    'phone' => $request->phone, 
                    'sex' => $request->sex, 
                    'password' => password_hash($request->newpassword, PASSWORD_BCRYPT), 
                    'active' => 1, 
                    'profile' => User::where('id', $request->id)->first()->profile == 1 ? 1 : 0
                    );
                    $update = User::where('id', $request->id)->update($arr);
                    return response()->json($update);
                }
            }else{
                return response()->json(false);
            }
        }
       
       return response()->json([]);
      
    }

    public function getAllItem(Request $request){
        $item =  User::select('*');
            
            if ($request->type == 0 && $request->category == 0) {
                # show all data
                $item = $item->join('item', 'users.id' , '=' , 'item.user_id')
                            ->where('item.active' , 1)
                            ->orderBy('item.created_at','DESC')->offset($request->start)->limit($request->end)->get();
            }else if($request->type == 2 && $request->category == 0){
                #show all cateogry and item found
                $item = $item->join('item', 'users.id' , '=' , 'item.user_id')
                            ->where('item.active' , 1)
                            ->where('item.item_type_id', '=', 2)
                            ->orderBy('item.created_at','DESC')->offset($request->start)->limit($request->end)->get();
            }else if($request->type == 1 && $request->cateogry == 0){
                #show all category and item lost
                 $item = $item->join('item', 'users.id' , '=' , 'item.user_id')
                            ->where('item.active' , 1)
                            ->where('item.item_type_id', '=', 1)
                            ->orderBy('item.created_at','DESC')->offset($request->start)->limit($request->end)->get();
            }else if($request->type == 0 && $request->category != 0){
                #show all type and filter by category idsss
                $item = $item->join('item', 'users.id' , '=' , 'item.user_id')
                            ->where('item.active' , 1)
                            ->where('item.item_category_id', '=', $request->cateogry)
                            ->orderBy('item.created_at','DESC')->offset($request->start)->limit($request->end)->get();
            }



            foreach ($item as $key) {
                $count =  Liker::where('item_id', $key->id)->get();
                $color =  Liker::where(array('item_id' => $key->id, 'user_id' => $request->id))->first();
                $key->liker = sizeof($count);
                $key->colorStatus = $color != null ? 'like' : 'unlike';

                $key->listComments = Comment:: where('item_id', $key->id)->get();

                $key->listMarkers = Location::select('latitude as lat', 'longitude as lng')->where('item_id', $key->id)->get();
            }

        return response()->json($item);
    }

     public function allItem($id){
        $item =  User::select('*')->join('item', 'users.id' , '=' , 'item.user_id')
                            ->where('item.active' , 1)
                            ->orderBy('item.created_at','DESC')->offset(1)->limit(5)->get();
            

            foreach ($item as $key) {
                $count =  Liker::where('item_id', $key->id)->get();
                $color =  Liker::where(array('item_id' => $key->id, 'user_id' => $id))->first();
                $key->liker = sizeof($count);
                $key->colorStatus = $color != null ? 'like' : 'unlike';

                $key->listComments = Comment:: where('item_id', $key->id)->get();

                $key->listMarkers = Location::select('latitude as lat', 'longitude as lng')->where('item_id', $key->id)->get();
            }

        return response()->json($item);
    }

    public function getAllCategory(){
        $data = ItemCategory::where('active',1)->get();
        return response()->json($data);
    }

    public function getIemProfile($id){
        $item =  User::select('*')
            ->join('item', 'users.id' , '=' , 'item.user_id')
            ->where('user_id', $id)
            ->orderBy('item.created_at','DESC')->get();
            foreach ($item as $key) {
                $count =  Liker::where('item_id', $key->id)->get();
                $color =  Liker::where(array('item_id' => $key->id, 'user_id' => $id))->first();
                $key->liker = sizeof($count);
                $key->colorStatus = $color != null ? 'like' : 'unlike';

                $key->listComments = Comment:: where('item_id', $key->id)->get();

                $key->listMarkers = Location::select('latitude as lat', 'longitude as lng')->where('item_id', $key->id)->get();

            }
        return $item;
    }

    public function processLogin(Request $request){
        // if ($request->isMethod('post')){    
        //     return response()->json(['response' => 'This is post method']); 
        // }
        return response()->json($request);
    }

    public function getFilterItemByCategory($id, $start, $end){
         $con = array(
            'item.active' => 1,
            'item.item_category_id' => $id,
          );
         $item =  User::select('*')
            ->join('item', 'users.id' , '=' , 'item.user_id')
            ->where($con)
            ->orderBy('item.created_at','DESC')->offset($start)->limit($end)->get();
            foreach ($item as $key) {
                $count =  Liker::where('item_id', $key->id)->get();
                $color =  Liker::where(array('item_id' => $key->id, 'user_id' => $key->user_id))->first();
                $key->liker = sizeof($count);
                $key->colorStatus = $color != null ? 'like' : 'unlike';

                $key->listComments = Comment:: where('item_id', $key->id)->get();

                $key->listMarkers = Location::select('latitude as lat', 'longitude as lng')->where('item_id', $key->id)->get();
            }

        return response()->json($item);
    }

    public function liker(Request $request){
        $msg = '';
        $arr = array(
            'item_id' => $request->itemId,
            'user_id' => $request->userId);
        $filter = Liker::where($arr)->first();
        if ($filter != null) {
            if ($filter->item_id == $request->itemId && $filter->user_id == $request->userId) {
                $filter->delete();
                $msg = "unlike";
            }else{
                $insert = new Liker($arr);
                $insert->save();
                $msg = 'like';
            }
        }else{
            $insert = new Liker($arr);
            $insert->save();
            $msg = "like";
        }
        
        return response()->json($msg);
    }

    public function comment(Request $request){
        $arr = array(
            'item_id' => $request->itemId, 
            'user_id' => $request->userId, 
            'comment' => $request->comment, 
            );
        $insert = new Comment($arr);
        $insert->save();
        return response()->json($insert);
    }

    public function getLocation($type , $category){
        $list = Location::select('location.latitude as lat', 'location.longitude as lng', 'item.item_type_id', 'item.item_name', 'users.email', 'users.phone');

        $total = 0;
        $countLocation = Location::select('*');
 

        if ($type == 1 && $category == 0) {
            $total = $countLocation->join('item', 'location.item_id', '=', 'item.id')->join('users', 'users.id', '=', 'item.user_id')->where('item.item_type_id', 1)->get()->count();
            $total = $total > 100 ? 100 : $total;
            $list = $list->join('item', 'location.item_id', '=', 'item.id')->join('users', 'users.id', '=', 'item.user_id')->where('item.item_type_id', 1)->get()->random($total);
        }else if($type == 2 && $category == 0){
            $total = $countLocation->join('item', 'location.item_id', '=', 'item.id')->join('users', 'users.id', '=', 'item.user_id')->where('item.item_type_id', 2)->get()->count();
            $total = $total > 100 ? 100 : $total;
            $list = $list->join('item', 'location.item_id', '=', 'item.id')->join('users', 'users.id', '=', 'item.user_id')->where('item.item_type_id', 2)->get()->random($total);

        }else if($category != 0){
            $total = $countLocation->join('item', 'location.item_id', '=', 'item.id')->join('users', 'users.id', '=', 'item.user_id')->where('item.item_category_id', $category)->get()->count();
            $total = $total > 100 ? 100 : $total;
            $list = $list->join('item', 'location.item_id', '=', 'item.id')->join('users', 'users.id', '=', 'item.user_id')->where('item.item_category_id', $category)->get()->random($total);
        }else{
            $total = $countLocation->join('item', 'location.item_id', '=', 'item.id')->join('users', 'users.id', '=', 'item.user_id')->get()->count();
            $total = $total > 100 ? 100 : $total;
            $list = $list->join('item', 'location.item_id', '=', 'item.id')->join('users', 'users.id', '=', 'item.user_id')->get()->random($total);
        }
        
        return response()->json($list);
    }

    public function postMessage(Request $request){

        $reciever_id = User::where('email', $request->reciever_email)->first()->id;
        $checkMessage = MainMessage::where('sender_id', $request->sender_id)->where('reciever_id', $reciever_id)->orWhere('sender_id', $reciever_id)->where('reciever_id', $request->sender_id)->first();
        
        $inId = 0;
        if ($checkMessage == null) {
            $arr = array('sender_id' => $request->sender_id, 'reciever_id' => $reciever_id );
            $in = new MainMessage($arr);
            $in->save();
            $inId = $in->id;
        }else{
            $inId = $checkMessage->id;
        }
        if ($reciever_id != null) {
            $data = array(
                'sender_id' => $request->sender_id, 
                'reciever_id' => $reciever_id, 
                'message' => $request->message,
                'main_id' => $inId,
                'status' => 'pending'
                );

            $insert = new Message($data);
            $insert->save();
            return response()->json($insert);
        }
        else{
            return response()->json('');
        }

        return response()->json($request);
    }

    public function listMessage($id){
        $data = MainMessage::where('sender_id', '=', $id)->orWhere('reciever_id', '=', $id)->orderBy('created_at','DESC')->get();
        foreach ($data as $key) {
            
            $eId = $key->reciever_id;
            if ($key->reciever_id == $id) {
              $eId = $key->sender_id;
            }  

            $i = User::where('id', $eId)->first();
            $key->email_reciever = $i->email;
             $key->icon_chating = $eId;
        }
        return response()->json($data);
    }

    public function getMessageDetail($mainId){

        $data = Message::where('main_id', $mainId)->get();
        $checking = MainMessage::where('id', $mainId)->where('status', 'pending')->first();

        $checkNotify = Notification::where('main_id', $mainId)->where('status', 'pending')->first();


        if ($checking != null) {
            $check = MainMessage::where('id', '=', $mainId)->first();


            $dataUpdate = array(
                'id' => $check->id,
                'sender_id' => $check->sender_id,
                'reciever_id' => $check->reciever_id,
                'status' => "checked"
            );

          
            MainMessage::where('id',$mainId)->update($dataUpdate);
        }


        if ($checkNotify != null) {
          $request = Notification::where('main_id', $mainId)->first();
          $dataNotify = array(
                'id' => $request->id,
                'sender_id' => $request->sender_id, 
                'reciever_id' => $request->reciever_id, 
                'key' => $request->key, 
                'value' => $request->value, 
                'main_id' => $request->main_id,
                'status' => "checked"
            );
            Notification::where('main_id',$mainId)->update($dataNotify);

        }

        return response()->json($data);
    }

    public function insertNotfication(Request $request){

            $check = Notification::where('sender_id', $request->sender_id)
                    ->where('reciever_id', $request->reciever_id)
                    ->orWhere('sender_id', $request->reciever_id)
                    ->where('reciever_id', $request->sender_id)->first();

            if ($check == null) {
                $data = array(
                    'sender_id' => $request->sender_id, 
                    'reciever_id' => $request->reciever_id, 
                    'key' => $request->key, 
                    'value' => $request->value, 
                    'main_id' => $request->main_id,
                    'status' => $request->status
                );

                $insert = new Notification($data);
                $insert->save();
                return response()->json($insert);
            }

            return response()->json([]);
           
    }

    public function getNotfication($auth){
        $lst = Notification::where('reciever_id', $auth)->orWhere('sender_id', $auth)->where('status','pending')->orderBy('created_at','DESC')->get();
        foreach ($lst as $key) {
            $eId = $key->reciever_id;
            if ($key->reciever_id == $auth) {
              $eId = $key->sender_id;
            }  
            $key->email_reciever = User::where('id', $eId)->first()->email;
            $key->icon_chating = $eId;
        }
        return response()->json($lst);
    }

    public function removeItem(Request $request){
        $delete = Item::where('id', $request->id)->delete();
        return response()->json("delete");
    }

    public function sendFeedback(Request $request){
        $data = array(
            'user_id' => $request->user_id, 
            'title' => $request->title, 
            'description' => $request->description,
            );
        $insert = new Feedback($data);
        $insert->save();
        return response()->json($insert);
    }

    public function getFilterByType($type, $start, $end){
        $con = array(
            'item.active' => 1,
            'item.item_type_id' => $type
          );
         $item =  User::select('*')
            ->join('item', 'users.id' , '=' , 'item.user_id')
            ->where($con)
            ->orderBy('item.created_at','DESC')->offset($start)->limit($end)->get();
            foreach ($item as $key) {
                $count =  Liker::where('item_id', $key->id)->get();
                $color =  Liker::where(array('item_id' => $key->id, 'user_id' => $key->user_id))->first();
                $key->liker = sizeof($count);
                $key->colorStatus = $color != null ? 'like' : 'unlike';

                $key->listComments = Comment:: where('item_id', $key->id)->get();

                $key->listMarkers = Location::select('latitude as lat', 'longitude as lng')->where('item_id', $key->id)->get();
            }

        return response()->json($item);
    }

    function compressItem($filename, $destination, $quality) {

        // Set a maximum height and width
        $width = $quality;
        $height = $quality;

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }
        // Content type
        header('Content-Type: image/jpeg');

        // Get new dimensions
        list($width_orig, $height_orig) = getimagesize($filename);

        $ratio_orig = $width_orig/$height_orig;

        if ($width/$height > $ratio_orig) {
           $width = $height*$ratio_orig;
        } else {
           $height = $width/$ratio_orig;
        }

        // Resample
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        // // Output
        return imagejpeg($image_p, $destination, 100);
    }
}
