<div>
    <div class="container">
        <div class="row">

            <div class="col-12 col-sm-4">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="text-center">Manteminiento</h5>
                        <br>
                        <!-- Default switch -->
                        <div class="custom-control custom-switch">
                            <input wire:change="mantenimiento" type="checkbox" class="custom-control-input" id="customSwitches" @if($mantenimiento->mantenimiento == 'on') checked @endif>
                            <label class="custom-control-label" for="customSwitches">Modo mantenimiento</label>
                        </div>
                        <br>
                        @if($token)
                        <div class="row">
                            <div class="col-4 offset-4">
                                <code>{{$token}}</code>
                            </div>
                            <span>*Copie este codigo y peguelo en la ruta principal anteponiendo "/" para poder entrar al sistema en modo mantenimiento.</span>
                            <span><b>Por favor, luego de copiar el codigo debe actualizar la pagina</b></span>
                        </div> 
                        @endif
                        
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-4">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="text-center">Paginación</h5>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-4">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="text-center">Imagenes</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</div>
