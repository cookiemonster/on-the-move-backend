<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Expertise;
use App\User;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Providers\RocketchatAuthProvider;

use Illuminate\Http\Request;

class ExpertiseController extends Controller
{
    use Helpers;

    public function index(Request $request) {
      $currentUser = RocketchatAuthProvider::getUser($request);
      return $currentUser
          ->expertises()
          ->orderBy('created_at', 'DESC')
          ->get()
          ->toArray();
    }

    public function store(Request $request) {
      $currentUser = RocketchatAuthProvider::getUser($request);

      $expertise = new Expertise;

      $expertise->expertise = $request->get('expertise');

      if($currentUser->expertises()->save($expertise)) {
        return response()
          ->json([
            'status' => 'ok',
            'expertise' => $expertise
        ]);
      } else {
          return $this->response->error('could_not_create_expertise', 500);
      }
    }

    public function show($id)
    {
        $expertises = Expertise::where('user_id', '=', $id)->get();

        if(!$expertises)
            throw new NotFoundHttpException;

        return $expertises;
    }

    public function update(Request $request, $id)
    {
        $currentUser = RocketchatAuthProvider::getUser($request);

        $expertise = $currentUser->expertises()->find($id);
        if(!$expertise)
            throw new NotFoundHttpException;

        $expertise->fill($request->all());

        if($expertise->save())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_expertise', 500);
    }

    public function destroy(Request $request, $id)
    {
        $currentUser = RocketchatAuthProvider::getUser($request);

        $expertise = $currentUser->expertises()->find($id);

        if(!$expertise)
            throw new NotFoundHttpException;

        if($expertise->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_expertise', 500);
    }

}
