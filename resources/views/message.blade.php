@extends('layout')

@section('content')
    <!-- Wrapper-->
    <div id="wrapper">

        <!-- Nav -->
        <nav id="nav">
            <a href="{{ env('SITE_URL') }}" class="icon fa-home active"><span>Home</span></a>
        </nav>

        <!-- Main -->
        <div id="main">
            <!-- Me -->
            <article id="me" class="panel">
                <header>
                    <h1>{!! wordwrap($message, 40, "<br><br>") !!}</h1>
                </header>
            </article>
        </div>

        <!-- Footer -->
        <div id="footer">
            <ul class="copyright">
                <li>&copy; <a href="/facebook/login">Marcos Salvador</a></li><li>Desenvolvido por <a href="http://antoniocarlosribeiro.com">Antonio Carlos Ribeiro</a></li>
            </ul>
        </div>
    </div>
@stop
