@extends('layouts.app')
@section('content')

	<!-- ROW-1 OPEN -->
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				
				<div class="card-body">
					<div class="clearfix">
						<div class="float-left">
							<h3 class="card-title mb-0">Nouveau Groupe</h3>
						</div>
						<div class="float-right">
							<h3 class="card-title">Date Création: ...................... </h3>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-lg-6 ">
							<p class="h3" style="cursor:pointer;"  data-toggle="modal" data-target="#myModal_modif" >Informations du Groupe : </p>

							<address>
								Année scolaire : ...................... <br>
								Niveau :  ...................... <br>
								Matière : ...................... <br>
								Tarif : ......................   
							</address>
						</div>
						<div class="col-lg-6 text-right">
							<p class="h3">Informations Prof : </p>
							<address>
								Prof : ...................... <br>
								Num tel :  ...................... <br>
								{{-- Pourcentage prof : {!! $groupe->pourcentage_prof !!} %<br> --}}
							</address>
						</div>
					</div>
				</div>
			<div class="row">
			<div class="col-md-3">
					<a type="button" style="color: #ffffff; margin: 1% 0%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter un élève </a>
				</div>
				<div class="col-md-3">
					<button type="button" style="color: #ffffff; margin: 1% 0%;" class="btn btn-primary"  id="btnPrint"> Imprimer </button>
				</div>

			</div>
			

			<div class="card-body">
				
				<div class="table-responsive">
					
					<table data-page-length='50' id="table-1" class="table table-striped table-bordered text-nowrap w-100">

						<thead>
							<tr>
								<th style="cursor: pointer;" class="wd-15p">N°</th>
								<th style="cursor: pointer;" class="wd-15p">Nom</th>
								<th style="cursor: pointer;" class="wd-15p">Prénom</th>
								<th style="cursor: pointer;" class="wd-15p">Num tel</th>
								<th style="cursor: pointer;" class="wd-15p">Séances</th>
								<th style="cursor: pointer; color: green;" class="wd-15p">Payé</th>
								<th style="cursor: pointer; color: red;" class="wd-15p">Retard</th>
							</tr>
						</thead>
                        
                        <tbody id="all_the_eleves">

                            @for($i=0 ; $i < 30 ; $i++)

                                <tr id="l_eleve{{$i}}">

                                    <form>

                                        {{ csrf_field() }}  

                                        <td style="width:5%;">

                                            {!! $i+1 !!}                                                
                                        </td>

                                        <td style="width:5%; ">

                                            ..................................................
                                        </td>

                                        <td style="width:5%; "> 
                                        	
											..................................................
                                        </td>

                                        <td style="width:5%; "> 
                                        	
											..................................................
                                        </td>


                                        <td style="width:40%;">
                                        		
											
                                        </td>

                                        <td style="width:20%;">
                                        	
                                        </td>


                                        <td style="width:20%; cursor:pointer;" onclick="goto_the_link(this)" id="eleve{{$i}}" groupe="">

                                        	
                                        	
                                        </td>

		                            	{{--  --}}
                                    </form>
                                    {{--  --}}
                                </tr>
                                {{-- expr --}}
                            @endfor
                            {{--  --}}
                        </tbody>
 					</table>
				</div>
				</div>
			</div>
		</div><!-- COL-END -->

	</div>
	<!-- ROW-1 CLOSED -->


	
	{{--  --}}
@endsection

@section('scripts')
<script type="text/javascript">
	
	$(document).ready(function(){
	    
	    $("#btnPrint").on('click',function(){
		// 		var divContents = $("#datable-1").html();
	            $('#table-1').printThis();
	    })

		/**/
	});

	
	

	/**/
</script>
@endsection