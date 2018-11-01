@extends('web_site.layouts.main')
@section('title', "Noticias")
@section('content')
  <!-- Principal -->
  <section id="x" class="x" data-stellar-background-ratio="0.2">
      <br/><br/><br/>
      <div class="container">
         
         
      </div>
  </section>
  <!-- Fi Principal -->

   
   <div class="linea-sobra"  id="noticias"></div>

  <!-- Noticias -->
  <div id="Noticias" class="section">

      <div class="container">
        <div class="section-header">
          <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Noticias</h2>
          <hr class="lines wow zoomIn" data-wow-delay="0.3s">
          <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s"><strong>Artículos relacionados con Proexcelencia AVAA de educación integral en Venezuela</strong></p>
        </div>

        <div class="row" >
          @foreach($noticias as $noticia)
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"  style="margin-bottom: 10px;">
            <a href="{{route('showNoticia',$noticia->slug)}}">
            <div  style="border: 1px solid #021f3a;padding-right: 0px;padding-left: 0px;">
              <img style="width: 100%;height: auto;" src="{{asset($noticia->url_imagen)}}">
              <div style="padding:10px; ">
                <p class="h4" style="color:#021f3a" data-mh="noticia-titulo">
                  <strong>{{ $noticia->titulo }}</strong>
                </p>
                <hr>
                <p class="h6" style="color:#9E9E9E">
                  04/02/2019 02:05 pm - Pedro Perez
                </p>
              </div>
            </div>
            </a>
          </div>
          @endforeach
          <div class="col-lg-12">
            <p style="color:#424242" class="text-right">{{ count($noticias) }}  noticia(s)</p>
          </div>
        </div>
      </div>
  </div>
  <!-- Fin Noticias -->
@endsection

@section('personaljs')
   <script type="text/javascript">
       $(document).ready(function() {
           $('#myTable').DataTable( {
               columnDefs: [
                   { targets: [0], searchable: false}
               ]
           } );
       } );

       $('#myTable')
           .removeClass( 'display' )
           .addClass('table-hover');

   </script>

@endsection