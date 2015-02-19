<?php namespace App\Http\Controllers;

use Exception;
use Input;
use Socialite;
use Redirect;
use Auth;
use App\Http\Requests\SendMail;
use App\Repositories\User as UserRepository;

class HomeController extends Controller {

	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function index()
	{

		return view('home')
			->with('photos', $this->userRepository->getAllPhotos())
			->with('telephones', explode('|', env('TELEPHONES')))
			->with('region', env('REGION'));
	}

	public function facebookLogin()
	{
		return Redirect::to($this->userRepository->facebookLogin());
	}

	public function facebookCallback()
	{
		try
		{
			$this->userRepository->fetchImages();
		}
		catch(Exception $e)
		{
			return view('message')->with('message', $e->getMessage());
		}

		return Redirect::route('fetched');
	}

	public function fetched()
	{
		return view('message')->with('message', 'As fotos do Facebook estão agora no site!');
	}

	public function sendMail(SendMail $request)
	{
		$this->userRepository->sendMail($request->all());

		return view('message')->with('message', 'Sua mensagem foi enviada, obrigado!');
	}

	public function privacy()
	{
		return view('privacy');
	}

}
