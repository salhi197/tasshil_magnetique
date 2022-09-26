@extends('layouts.home')

@section('content')

<div class="page-header">
						<h4 class="page-title">Profile</h4>
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Pages</a></li>
							<li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
						</ol>
					</div>
					<!-- PAGE-HEADER END -->

					<!-- ROW-1 OPEN -->
					<div class="row">
						<div class="col-lg-4 col-xl-4 col-md-12 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="text-center">
										<div class="userprofile">
											<div class="userpic  brround"> <img src="../../assets/images/users/female/16.jpg" alt="" class="userpicimg"> </div>
											<h3 class="username text-dark mb-2">{{$eleve->nom ?? ''}} {{$eleve->prenom ?? ''}}</h3>
											<p class="mb-1 text-muted">{{$groupe->matiere}}</p>
											<div class="socials text-center mt-3">
                                                <a href="/home/seance/annuler/{{$matricule}}/{{$seance->id}}" class="btn btn-success mt-1"><i class="fa fa-close"></i> Annuler Séance</a>												
											</div>
										</div>
									</div>
								</div>
							</div>
							
							
						</div>
						<div class="col-lg-8 col-xl-8 col-md-12 col-sm-12">
							<div class="card">
								<div class="card-header text-center">
									<h3 class="card-title text-center">{{$groupe->matiere}} </h3>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="exampleInputname">Nom</label>
												<input type="text" class="form-control" id="exampleInputname" value="{{$eleve->nom}}">
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="exampleInputname1">Prénom</label>
												<input type="text" class="form-control" id="exampleInputname1" value="{{$eleve->prenom}}">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="exampleInputnumber">Téléphone</label>
										<input type="number" class="form-control" id="exampleInputnumber" value="{{$eleve->num_tel}}">
									</div>
									
                                    
									
									
								<div class="card-footer">
                                    <p>
                                        <strong>NB</strong> : Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. 
                                    </p>
								</div>
							</div>
							
						</div>
					</div>
					<!-- ROW-1 CLOSED -->

					<!-- ROW-2 OPEN -->
					
					<!-- ROW-2 CLOSED -->       






@endsection
