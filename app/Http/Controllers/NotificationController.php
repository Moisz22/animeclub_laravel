<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $notificaciones = DB::table('audit')->orderBy('visto')->orderBy('created_at')->get();
        /* DB::table('audit')->where('visto', false)->update([
            'visto' => true
        ]); */
        return view('admin.notificaciones.index', compact('notificaciones'));
    }

    public function consultadata()
    {
        $notificaciones = DB::table('audit')->orderBy('visto')->orderBy('created_at')->get();
        $jsonfinal = [];
        $array_temp = [];
        $pendiente = '';
        foreach ($notificaciones as $not)
        {
            if(!$not->visto) $pendiente = '<i class="fas fa-circle text-primary d-block m-auto"></i>';
            $array_temp = [$not->id,$not->user_id, $not->accion, $not->tabla, $not->created_at, $pendiente]; 
            array_push($jsonfinal, $array_temp);
            $pendiente = '';
        }
        return response()->json(['data' => $jsonfinal]);
    }

    public function getNotificationsData(Request $request)
    {
        $notifications = [];
        $tiempo_usuario = '';
        $tiempo_rol = '';
        $usuarios = DB::table('audit')->where([['visto', false], ['tabla', 'usuarios']])->orderBy('created_at', 'desc')->get();
        $roles = DB::table('audit')->where([['visto', false], ['tabla', 'role']])->orderBy('created_at', 'desc')->get();

        

        if(sizeof($usuarios)>0)
        {
            foreach($usuarios as $usuario)
            {
                $tiempo_usuario = $usuario->created_at;
                break;
            }

            array_push($notifications,[
                'icon' => 'fas fa-fw fa-users text-primary',
                'text' => sizeof($usuarios) . ' incidencia usuarios',
                'time' => Carbon::now()->diffInMinutes(date($tiempo_usuario)) . ' minutes',
            ]);
        }

        if(sizeof($roles)>0)
        {
            foreach($roles as $rol)
            {
                $tiempo_rol = $rol->created_at;
                break;
            }

            array_push($notifications,[
                'icon' => 'fas fa-fw fa-user-tag text-primary',
                'text' => sizeof($roles) . ' incidencia roles',
                'time' => Carbon::now()->diffInMinutes(date($tiempo_rol)) . ' minutes',
            ]);
        }
    
        // Now, we create the notification dropdown main content.
    
        $dropdownHtml = '';
    
        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";
    
            $time = "<span class='float-right text-muted text-sm'>
                       {$not['time']}
                     </span>";
    
            $dropdownHtml .= "<a href='#' class='dropdown-item'>
                                {$icon}{$not['text']}{$time}
                              </a>";
    
            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }
    
        // Return the new notification data.
    
        return [
            'label'       => count($usuarios) + count($roles),
            'label_color' => 'danger',
            'icon_color'  => 'warning',
            'dropdown'    => $dropdownHtml,
        ];
    }

    public function marcar_todas()
    {
        DB::table('audit')->where('visto', false)->update([
            'visto' => true
        ]);

        return response()->json(['sms' => 'ok']);
    }
}
