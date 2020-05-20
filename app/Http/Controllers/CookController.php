<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cook;
use App\Meal;
use App\User;

class CookController extends Controller
{
    public function store(Request $request)
    {
    	$user = auth()->user();
    	$whosEat = $request->who_eat;
    	array_push( $whosEat, $user->id);
    	$totalPeopleEat = count($whosEat);
    	$price = $request->price;
    	$moneyPerson = round($price/$totalPeopleEat);
    	$cook = Cook::create([
    		'user_id' => $user->id,
    		'price' => $price,
    		'note' => $request->note,
    	]);
    	$peopleEat = [];
    	foreach ($whosEat as $person) {
    		 array_push($peopleEat,[
                'cook_id' => $cook->id,
    			'user_id' => $person,
    			'money_one_person' => $moneyPerson
                ]);
    	}
    	$result = Meal::insert($peopleEat);
    	return response()->json([
    	    'total'=> $result
        ]);

    }

}
