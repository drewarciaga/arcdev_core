<?php
 
namespace ArcdevPackages\Core\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role_names = null): Response
    {
        if(!Auth::check()){
            Auth::logout();
            return redirect('/login');
        }

        $roles = explode('|',$role_names);
        $user = User::find(Auth::user()->id);
        
        if(!empty($user->super_admin) || $user->hasRole('super_admin')){
            return $next($request);
        }

        foreach($roles as $role){
            if(Auth::user()->hasRole($role)){
                if(in_array($role, ['member','seller'])){
                    //check member subscription here
                    /*if($subscribed){

                    }else{
                        return redirect()->route('ExpiredMembership');
                        */
                }

                return $next($request);
            }
        }

        return redirect()->route('unauthorized');
    }
 
}