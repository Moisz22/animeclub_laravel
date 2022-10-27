<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class NotificationController extends Controller
{

    public function convertir_tiempo($tiempo)
    {
        $diferenciaSegundos = Carbon::now()->diffInSeconds(date($tiempo));
        $diferenciaMinutos = Carbon::now()->diffInMinutes(date($tiempo));
        $diferenciaHoras = Carbon::now()->diffInHours(date($tiempo));
        $diferenciaDias = Carbon::now()->diffInDays(date($tiempo));

        if( $diferenciaSegundos < 59 )
        {
            return ($diferenciaSegundos > 1) ? 'Hace '. $diferenciaSegundos.' segundos' : 'Hace '.$diferenciaSegundos.' segundo';
        }
        else if( $diferenciaSegundos > 59 && $diferenciaMinutos <= 59 )
        {
            return ($diferenciaMinutos > 1) ? 'Hace '. $diferenciaMinutos.' minutos' : 'Hace '.$diferenciaMinutos.' minuto';
        }
        else if( $diferenciaMinutos > 59 && $diferenciaHoras <=23 )
        {
            return ($diferenciaHoras > 1) ? 'Hace '. $diferenciaHoras.' horas' : 'Hace '.$diferenciaHoras.' hora';
        }
        else if($diferenciaDias >= 1)
        {
            return ($diferenciaDias > 1) ? 'Hace '. $diferenciaDias.' días' : 'Hace '.$diferenciaDias.' día';
        }
        
    }

    public function index()
    {
        $notificaciones = DB::table('audit')->orderBy('visto')->orderBy('created_at')->get();
        return view('admin.notificaciones.index', compact('notificaciones'));
    }

    public function marcarNotificacionLeida(Request $request)
    {
        DB::table('audit')->where('id', $request->id)->update([
            'visto' => true
        ]);
        return response()->json(['sms' => 'ok']);
    }

    public function consultadata()
    {
        $notificaciones = DB::table('audit')->orderBy('visto')->orderBy('created_at','desc')->limit(20)->get();
        $jsonfinal = [];
        $array_temp = [];
        $pendiente = '';
        $color_texto_tiempo = 'text-secondary';
        $usuario = '';

        $imagen_agregar = asset('iconos/agregar.png');
        $imagen_delete = asset('iconos/trash.png');
        $imagen_editar = asset('iconos/pencil.png');

        foreach ($notificaciones as $not)
        {
            $usuario = User::withTrashed()->find($not->user_id);
            
            if($not->metodo == 'create')
            {
                $imagen2 = $imagen_agregar;
            }
            else if($not->metodo == 'update')
            {
                $imagen2 = $imagen_editar;
            }
            else
            {
                $imagen2 = $imagen_delete;
            }

            if(!$not->visto)
            {
                $pendiente = '<i class="fas fa-circle text-primary d-block m-auto"></i>';
                $color_texto_tiempo = 'text-primary';
            } 
            $array_temp = [$not->id,$not->metodo,'<div style="position: relative; left: 0; top: 0;"><img class="heaven user-image img-circle elevation-2" width="60px" height="60px" src="'.asset('img/avatars'). '/'. $usuario->profile_photo_path.'" class="user-image img-circle elevation-3"><img class="eye" src="'. $imagen2 .'"> </div>', $not->accion.'<p class="'.$color_texto_tiempo.'">'. $this->convertir_tiempo($not->created_at).'</p>', $not->tabla, $not->created_at, $pendiente]; 
            array_push($jsonfinal, $array_temp);
            $pendiente = '';
            $color_texto_tiempo = 'text-secondary';
            $imagen2 = '';
        }
        return response()->json(['data' => $jsonfinal]);
    }

    public function getNotificationsData(Request $request)
    {
        $notifications = [];
        $tiempo_usuario = '';
        $tiempo_rol = '';
        $tiempo_genero = '';
        $usuarios = DB::table('audit')->where([['visto', false], ['tabla', 'usuarios']])->orderBy('created_at', 'desc')->get();
        $roles = DB::table('audit')->where([['visto', false], ['tabla', 'role']])->orderBy('created_at', 'desc')->get();
        $generos = DB::table('audit')->where([['visto', false], ['tabla', 'genero']])->orderBy('created_at', 'desc')->get();

        if(sizeof($usuarios)>0)
        {
            foreach($usuarios as $usuario)
            {
                $tiempo_usuario = $usuario->created_at;
                break;
            }

            array_push($notifications,[
                'icon' => 'fas fa-fw fa-users text-primary',
                'text' => sizeof($usuarios) . ' usuarios',
                'time' => $this->convertir_tiempo($tiempo_usuario),
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
                'text' => sizeof($roles) . ' roles',
                'time' => $this->convertir_tiempo($tiempo_rol),
            ]);
        }

        if(sizeof($generos)>0)
        {
            foreach($generos as $genero)
            {
                $tiempo_genero = $genero->created_at;
                break;
            }

            array_push($notifications,[
                'icon' => 'fas fa-fw fa-file-video text-primary',
                'text' => sizeof($generos) . ' géneros',
                'time' => $this->convertir_tiempo($tiempo_genero),
            ]);
        }
    
        // Now, we create the notification dropdown main content.
    
        $dropdownHtml = '';
        
        if($notifications)
        {
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
        }
    
        // Return the new notification data.
    
        return [
            'label'       => count($usuarios) + count($roles) + count($generos),
            'label_color' => 'danger',
            'icon_color'  => 'warning',
            'dropdown'    => $dropdownHtml,
        ];
    }

    public function marcar_todas()
    {
        DB::table('audit')->where('visto', false)->update([
            'visto' => true,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(['sms' => 'ok']);
    }
}
