@extends('layout')

@section('content')
	<!-- Wrapper-->
	<div id="wrapper">

		<!-- Nav -->
		<nav id="nav">
			<a href="#me" class="icon fa-home active"><span>Home</span></a>
			<a href="#work" class="icon fa-folder"><span>Trabalho</span></a>
			<a href="#contact" class="icon fa-envelope"><span>Contact</span></a>
			<a href="https://www.facebook.com/antoniocarlosr" target="_blank" class="icon fa-facebook"><span>Facebook</span></a>
		</nav>

		<!-- Main -->
		<div id="main">

			<!-- Me -->
			<article id="me" class="panel">
				<header>
					<h1>Marcos Salvador</h1>
					<p>Mestre de Obras</p>
				</header>

				<a href="#work" class="jumplink pic">
					<span class="arrow icon fa-chevron-right"><span>Veja o meu trabalho</span></span>
					<img src="images/me.jpg" alt="" />
				</a>
			</article>

			<!-- Trabalho -->
			<article id="work" class="panel">
				<header>
					<h2>Portifólio</h2>
				</header>
				<p>
					Reformas em geral, colocação de piso, reforma elétrica, sinteko. Veja abaixo algumas fotos dos meus trabalhos.
				</p>
				<section>
					<div class="row">
						<?php $counter = 1; ?>
						@foreach($photos as $photo)
							<div class="4u">
								<a href="#" class="image fit"><img src="{{ $photo->url }}" alt=""></a>
							</div>

							<?php
								if ($counter++ % 3 == 0)
								{
									?> <\div><div class="row"> <?php
								}
							?>
						@endforeach
					</div>
				</section>
			</article>

			<!-- Contact -->
			<article id="contact" class="panel">
				<header>
					<h2>Entre Em Contato</h2>
				</header>

				<h4>Região</h4>
				<p>
					Rio de Janeiro, Capital e Grande Rio.
				</p>

				<h4>Telefones</h4>
				<p>
					21-9-8088-2233 (Claro)<br>
					21-7088-2211 (Nextel)
				</p>

				<h4>Envie Uma Mensagem</h4>

				@if ($errors->has())
					@foreach($errors->all() as $error)
						<div class="alert-box error"><span>erro: </span>{{ $error }}</div>
					@endforeach
				@endif

				{!! Form::open() !!}
					<div>
						<div class="row">
							<div class="6u">
								{!! Form::text('name', null, ['placeholder' => 'Nome', 'required' => 'required']) !!}
							</div>
							<div class="6u">
								{!! Form::text('email', null, ['placeholder' => 'Email', 'required' => 'required']) !!}
							</div>
						</div>
						<div class="row">
							<div class="12u">
								{!! Form::text('subject', null, ['placeholder' => 'Assunto', 'required' => 'required']) !!}
							</div>
						</div>
						<div class="row">
							<div class="12u">
								{!! Form::textarea('message_body', null, ['placeholder' => 'Mensagem', 'required' => 'required', 'rows' => 8]) !!}
							</div>
						</div>
						<div class="row">
							<div class="12u">
								<input type="submit" value="Enviar Mensagem" />
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			</article>

		</div>

		<!-- Footer -->
		<div id="footer">
			<ul class="copyright">
				<li>&copy; <a href="/facebook/login">Marcos Salvador</a></li><li>Desenvolvido por <a href="http://antoniocarlosribeiro.com">Antonio Carlos Ribeiro</a></li>
			</ul>
		</div>
	</div>
@endsection
