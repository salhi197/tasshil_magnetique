<div id="myModal_modif" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

           	<div class="modal-header text-center">

                <h4 class="modal-title alert alert-info">Modifier le Groupe</h4>
          	</div>

            <div class="modal-body">

                <form class="form-inline" method="POST" action="/home/groupes/modifier">

                    {{ csrf_field() }}  

                    <input style="display:none;" type="number" id="id_groupe" name="id_groupe" value="{{ $groupe->id }}">

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="jourdugroupe">jour </label>

                        <select id="jourdugroupe" onchange="fit_salles();" required="true" name="jour" class="form-control col-md-12">

                            <option value="{{ $groupe->jour }}">{!! $groupe->jour !!}</option>

                            <option value="Dimanche"> Dimanche </option>
                            <option value="Lundi"> Lundi </option>
                            <option value="Mardi"> Mardi </option>
                            <option value="Mercredi"> Mercredi </option>
                            <option value="Jeudi"> Jeudi </option>
                            <option value="Vendredi"> Vendredi </option>
                            <option value="Samedi"> Samedi </option>
                        </select>

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="heure_debutdugroupe">Heure Début</label>

                        <input type="time" value="{!! $groupe->heure_debut !!}" onchange="fit_salles();" id="heure_debutdugroupe" required name="heure_debut" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="heure_findugroupe">Heure Fin</label>

                        <input type="time" value="{!! $groupe->heure_fin !!}" onchange="fit_salles();" id="heure_findugroupe" required name="heure_fin" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="salledugroupe">salle </label>

                        <select id="salledugroupe" onchange="fit_salles();" required="true" name="salle" class="form-control col-md-12">

                            <option value="{{ $groupe->classe }}">{!! $groupe->classe !!}</option>

                            @foreach ($salles as $salle)
                                
                                <option value="{{ $salle->num }}"> {!! $salle->num !!} </option>

                                {{-- expr --}}
                            @endforeach

                        </select>

                        {{--  --}}
                    </div>
                    
                    <div class="form-group col-md-4 col-sm-12">

                        <label for="niveaudugroupe">Niveau </label>

                        <select name="niveau" onchange="fit_tarif(this)" id="niveaudugroupe" class="form-control  col-md-12">
                            
                            <option value="{{ $groupe->niveau }}">{!! $groupe->niveau !!}</option>

                            @foreach ($niveaux as $niveau)
                            
                                <option value="{{ $niveau->niveau }}-{{ $niveau->cycle}}-{{$niveau->filiere }}">{!! $niveau->niveau !!}-{!! $niveau->cycle !!}-{!! $niveau->filiere !!}</option>
                            
                            @endforeach                            
                            
                            
                            {{--  --}}
                        </select>

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="matieredugroupe">Matière </label>

                        <select name="matiere" onchange="fit_prof(this)" id="matieredugroupe" class="form-control col-md-12 ">
                            
                            <option value="{{ $groupe->matiere }}"> {!! $groupe->matiere !!} </option>

                            @foreach ($matieres as $matiere)
                            
                                <option value="{{ $matiere->nom }}">{!! $matiere->nom !!}</option>
                            
                            @endforeach                            
                            
                            
                            {{--  --}}
                        </select>

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="profdugroupe"> Prof </label>

                        <select name="prof" id="profdugroupe" class="form-control col-md-12 ">
                            
                            <option id="{{ $groupe->prof }}" value="{{ $groupe->prof }}">{!! $groupe->prof !!}</option>

                            @foreach ($profs as $prof)
                            
                                <option id="{{ $prof->nom }}-{{ $prof->prenom }}" value="{{ $prof->nom }}-{{ $prof->prenom }}">{!! $prof->nom !!}-{!! $prof->prenom !!} &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</option>
                            
                            @endforeach                            
                            
                            
                            {{--  --}}
                        </select>

                        {{--  --}}
                    </div>

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="pourcentage_profdugroupe"> % Prof </label>

                        <input type="number" value="{{ $groupe->pourcentage_prof }}" onchange="fit_prctg(this);" value="50" min="30" max="100" id="pourcentage_profdugroupe" required name="pourcentage_prof" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div style="display:none;" class="form-group col-md-4 col-sm-12">

                        <label for="pourcentage_ecoledugroupe"> % Ecole </label>

                        <input type="number" value="{{ $groupe->pourcentage_ecole }}" disabled value="50" id="pourcentage_ecoledugroupe" required name="pourcentage_ecole" class="form-control col-md-12">

                        {{--  --}}
                    </div>

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="tarif"> Tarif </label>

                        <input type="number" min="0" id="tarif" required name="tarif" value="{{ $groupe->tarif }}" class="form-control col-md-12">

                        {{--  --}}
                    </div>



                    <input type="submit" style="color: #2070F5; margin-top: 5%;" class="btn btn-outline-info col-md-12" value="Modifier">

                </form>

                {{--  --}}
            </div>

            <div class="modal-footer">

                <a type="button" style="color: #ffffff;" class="btn btn-warning" data-dismiss="modal">Fermer</a>

            </div>

        </div>

        {{--  --}}
  </div>

</div>                    
