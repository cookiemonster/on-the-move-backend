<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\User;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Providers\RocketchatAuthProvider;


use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    use Helpers;

    public function index() {
      $currentUser = User::all()->except(JWTAuth::parseToken()->authenticate()->id);
      return $currentUser;
    }

/*     public function show($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $users = $currentUser->users()->find($id);

        if(!users)
            throw new NotFoundHttpException;

        return $users;
    }
*/
    public function getProfile(Request $request)
    {
        $user = RocketchatAuthProvider::getUser($request);

        return response()
            ->json([
                'status' => 'ok',
                'user' => $user
            ]);
    }

    public function createOrUpdate(Request $request){
        $rcid = $request->headers->get('X-User-Id');
        if($request->input('rcid') != $rcid && $request->input('rcid') != ''){
            $this->response->error('you can\'t change your rcid', 500);
        }

        $user = User::firstOrCreate(['rcid' => $rcid]);
        $user->fill($request->all());
        $user->rcid = $rcid;


        if($user->save())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_or_create_user', 500);

    }

    public function search($search){
        return User::
            limit(25)
            ->whereHas('expertises', function($q) use ($search){
                $q->where('expertise', 'like', '%'.$search.'%');
            })
            ->orWhere('voornaam', 'like', '%'.$search.'%')
            ->orWhere('achternaam', 'like', '%'.$search.'%')
            ->orWhere('organisatieonderdeel', 'like', '%'.$search.'%')
            ->orWhere('overmij', 'like', '%'.$search.'%')
            ->orWhere('taken', 'like', '%'.$search.'%')
            ->orWhere('functie', 'like', '%'.$search.'%')
            ->get();
    }
}
