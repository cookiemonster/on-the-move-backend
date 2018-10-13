<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'achternaam',
        'voornaam',
        'email',
        'organisatieonderdeel',
        'telefoonnummermobiel',
        'telefoonnummervast',
        'achtervang',
        'werktijden',
        'kamer',
        'overmij',
        'taken',
        'profielafbeelding',
        'rcid',
        'rcusername',
        'functie'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


    public function expertises()
    {
      return $this->hasMany('App\Expertise');
    }

}
