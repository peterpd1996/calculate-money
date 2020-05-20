<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $users = User::where('id', '!=', $user->id)
            ->get();
        return view('home', compact('users'));
    }

    public function removePersonNotPay($moneys)
    {
        foreach ($moneys as $key => $money)
        {
            if ($money["value"] >= 0 && $money["value"] < 1)
            {
                unset($moneys[$key]);
            }
        }
        return $moneys;
    }

    public function sortArray($array, $mode)
    {
        $price = array_column($array, 'value');
        array_multisort($price, $mode, $array);
        return $array;
    }
    
    public function calculateMoney($moneys)
    {
        $result = "";
        $moneys = $this->removePersonNotPay($moneys);

        foreach ($moneys as $userId => $money)
        {
            if ($money["value"] >= 0)
            {
                $plusMoney[$userId] = $money;
            }
            else
            {
                $minusMoney[$userId] = $money;
            }
        }
        $plusMoney = $this->sortArray($plusMoney, SORT_ASC);
        $minusMoney = $this->sortArray($minusMoney, SORT_DESC);
        foreach ($minusMoney as $userIdMinus => $valueMinus)
        {
            foreach ($plusMoney as $userIdPlus => $valuePlus)
            {
                $change = $valueMinus["value"] + $valuePlus["value"];
                if ($change > 0)
                {
                    $result .= $valueMinus["name"] . " nợ " . $valuePlus["name"] . " " . $valueMinus["value"] * (-1) . "k" . "\n";
                    $plusMoney[$userIdPlus]["value"] += $valueMinus["value"];
                    break;
                }
                elseif ($change < 0)
                {
                    $result .= $valueMinus["name"] . " nợ " . $valuePlus["name"] . " " . $valuePlus["value"] . "k" . "\n";
                    unset($plusMoney[$userIdPlus]);
                    $valueMinus = $change;
                }
                elseif ($change >= 0 && $change < 1)
                {
                    $result .= $valueMinus["name"] . " nợ " . $valuePlus["name"] . " " . $valueMinus["value"] * (-1) . "k" . "\n";
                    $plusMoney[$userIdPlus]["value"] += $valueMinus["value"];
                    unset($plusMoney[$userIdPlus]);
                    break;
                }

            }
        }
        return $reslut;
    }

}

