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

        // Full-access roles bypass every role-gated route. Driven by config
        // (config/core.php => full_access_roles, default ['super_admin']) so
        // consuming apps can opt extra roles in via CORE_FULL_ACCESS_ROLES
        // without affecting any other app. Default behavior is unchanged.
        $fullAccessRoles = config('core.full_access_roles', ['super_admin']);

        if(!empty($user->super_admin) || $user->hasAnyRole($fullAccessRoles)){
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