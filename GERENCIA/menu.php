<nav class="navbar navbar-custom navbar-fixed-top noprint" role="navigation" style="background-color: #FF0000">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span>SINDPROF</span> 1.0</a>
			</div>
		</div><!-- /.container-fluid -->
	</nav>



	<div id="sidebar-collapse noprint" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="https://bootdey.com/img/Content/user_1.jpg" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">ADM</div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu"  role="tablist">
			<li  class="active">
				<a  data-toggle="tab" href="#tela_midias" role="tab" aria-controls="home" aria-selected="true">
					MIDIAS
				</a>
			</li>
			<?php
			if ($_SESSION['token'] == '33') {
			?>
			<li>
				<a  data-toggle="tab" href="#tela_transmissao" role="tab">
					TRANSMISSÃO
				</a>
			</li>
			<?php
			}
			?>
			
			<li>
				<a  data-toggle="tab" href="#tela_base_dados" role="tab" aria-controls="home" aria-selected="true">
					BASE DE DADOS
				</a>
			</li>
			<li>
				<a  data-toggle="tab" href="#tela_campanhas" role="tab" aria-controls="home" aria-selected="true">
					CAMPANHAS
				</a>
			</li>
			
			<li>
				<a  data-toggle="tab" href="#tela_whatscampanha" role="tab" aria-controls="home" aria-selected="true">
					#WHATSAPP#
				</a>
			</li>
			
			<li>
				<a data-toggle="tab" href="#tela_2" role="tab" aria-controls="contact" aria-selected="false">
					ATENDENTES
				</a>
			</li>

			<li>
				<a data-toggle="tab" href="#tela_3" role="tab" aria-controls="contact" aria-selected="false">
					CANAIS
				</a>
			</li>

			<li>
				<a  href="_deslogar.php" role="tab" aria-controls="contact" aria-selected="false">
					SAIR
				</a>
			</li>

		</ul>

	</div>