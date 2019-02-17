 <table >
    <thead>
        <tr>
            <td colspan="7">NÓMINA GENERADA: {{$mes_completo}}-{{$anho}}</td>
        </tr>
        <tr>
            <td style="background-color: #eeeeee">#</td>
            <td style="background-color: #eeeeee">Nombres</td>
            <td style="background-color: #eeeeee">Apellidos</td>
            <td style="background-color: #eeeeee">Cédula</td>
            <td style="background-color: #eeeeee">Correo Electrónico</td>
            <td style="background-color: #eeeeee">N° Cuenta</td>
            <td style="background-color: #eeeeee">Total a Pagar</td>
        </tr>                         
    </thead>
    <tbody>
        @for($i=0;$i<$nominas->count();$i++)
        <tr>
            <td>
                {{ $i+1}}
            </td>
            <td> {{ $nominas[$i]->datos_nombres}} </td>
            <td> {{ $nominas[$i]->datos_apellidos }} </td>
            <td> {{ $nominas[$i]->datos_cedula }} </td>
            <td> {{ $nominas[$i]->datos_email }} </td>
            @if( $nominas[$i]->datos_cuenta != null)
                <td> {{ $nominas[$i]->datos_cuenta }} </td>
            @else
                <td>SIN NÚMERO DE CUENTA</td>
            @endif
            <td>{{number_format($nominas[$i]->total, 2, ',', '')}}</td>
        </tr>

        @endfor

    </tbody>
</table>