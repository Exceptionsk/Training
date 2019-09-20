<?php
namespace App\Http\Controllers\Core;

use App\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Core\Log\LogRepositoryInterface;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogController extends Controller
{
    private
        $logRepository;

    public function __construct(LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
        $this->middleware('right');
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            //if (Auth::guard('User')->user()->role_id == 1) {
                $logs      = $this->logRepository->getlogs();
                $cur_time   = Carbon::now();
                return view('core.log.index')->with('logs', $logs)->with('cur_time',
                    $cur_time);
            //}
        }
        return redirect('/backend/login');
    }
}
