@extends('layouts.app')

@section('content')
	<div class="page-header">
		<h4 class="page-title">Détails sur le payement de l'élève : {!! $eleve->nom !!} {!! $eleve->prenom !!}</h4>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="clearfix">
						<div class="float-left">
							<h3 onclick="come_back(this)" id="dawra{{$dawra ?? ''}}" class="card-title mb-0" style="cursor:pointer;" >dawra : </h3>
						</div>
					</div>

					<hr>

					<div class="row">

						<div class="col-lg-6 ">
							<p class="h3">Informations sur l'élève : </p>
							<address>
								Nom : {!! $eleve->nom !!}<br>
								Prénom : {!! $eleve->prenom !!}<br>
								Numéro tel : {!! $eleve->num_tel !!}<br>
							</address>
						</div>

						<div class="col-md-3">
							<button type="button" style="color: #ffffff; margin: 1% 0%;" class="btn btn-primary"  id="btnPrint"> Imprimer </button>
						</div>

						{{--  --}}
					</div>
					
					<div class="table-responsive push">
						<table class="table table-bordered table-hover" id="table-print">
							
							<tbody>
								<tr class="">
									<th class="text-center">Numéro</th>
									<th class="text-center">Montant</th>
									<th class="text-center">Date Payment</th>
								</tr>
								@foreach ($dawarapayments as $key=>$dawarapayment)
                                    <tr>
										<td class="text-center" style="width: 2%;">{!! $key+1 !!}</td>
										<td class="text-center" style="width: 25%;">
                                            Montant Payé : {{$dawarapayment->montant}} DA
                                        </td>

										<td class="text-center" style="width: 25%;">
                                            {{$dawarapayment->created_at ?? ''}} 
										</td>
									</tr>
                                @endforeach
							</tbody>
						</table>
					</div>
				</div>

				{{--  --}}
			</div>
		</div><!-- COL-END -->
	</div>

	<!-- ROW-1 CLOSED -->

	<script src="{{ asset('js/gerer_retard.js') }}"></script>

@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    console.log($("#btnPrint").html());
    $("#btnPrint").on('click',function(){
//            var divContents = $("#datable-1").html();
            $('#table-print').printThis();
    })
});



</script>
@endsection