 <table >
    <thead>
        <tr>
            <td colspan="7">NÓMINA GENERADA: {{$mes_completo}}-{{$anho}}</td>
        </tr>
        <tr>
            <td style="background-color: #003865; color:#ffffff">#</td>
            <td style="background-color: #003865; color:#ffffff">APELLIDOS</td>
            <td style="background-color: #003865; color:#ffffff">NOMBRES</td>
        
            <td style="background-color: #003865; color:#ffffff">CEDULA</td>
            <td style="background-color: #003865; color:#ffffff; margin:50px">N° Cuenta</td>
            <th style="background-color: #003865; color:#ffffff">CVA</th>
            <th style="background-color: #003865; color:#ffffff">LIBROS CVA</th>
            <th style="background-color: #003865; color:#ffffff">RETROACTIVO</th>
            <th style="background-color: #003865; color:#ffffff">PAGO MENSUAL</th>
            <th style="background-color: #003865; color:#ffffff">TOTAL A PAGAR</th>
            <th style="background-color: #003865; color:#ffffff">BECA APROBADA</th>
            <th style="background-color: #003865; color:#ffffff">INGRESO</th>
            <th style="background-color: #003865; color:#ffffff">EGRESO</th>
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
            @if( $nominas[$i]->datos_cuenta != null)
                <td> {{ $nominas[$i]->datos_cuenta }} </td>
            @else
                <td>SIN NÚMERO DE CUENTA</td>
            @endif
            <td>{{number_format($nominas[$i]->cva, 2, ',', '')}}</td>
            <td>{{number_format($nominas[$i]->monto_libros, 2, ',', '')}}</td>
            <td>{{number_format($nominas[$i]->retroactivo, 2, ',', '')}}</td>
            <td>{{number_format($nominas[$i]->sueldo_base, 2, ',', '')}}</td>
            <td>{{number_format($nominas[$i]->total, 2, ',', '')}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        @endfor

    </tbody>
</table>