<?php

namespace App\Repositories;

use App\Photo;
use App\User as UserModel;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Contracts\Foundation\Application;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class User {

	// http://local.marcos.com/fetch?code=AQBTZRx_hnUcriYvS9h4TK8iKIKB_WYRvipLDuAa32F0IdCLkrd68tbLOo0chmPWba4fmzCerADLAXrJ7jA3yDEPoNmEbEHsKnyjxCTw6J5j5CFPuQeiUqTfu_l6E4-T796pTw3Goc4h82EYOQEQ__6jKrUwc16OAYs0sP6M63WhpPjZ3-3g8wHbjRHqAmSPsSoVVJ7tQDo6s464-M0wJdHBH4BlTA3BerBXCLndBxN6DrtaWW7qssolPZcfsuJYzjD60E7u8b2wVByZzyaOxLZnIf7O4XYsXhcN9QiFRZF7mMiWkRtByzmvYOVz3G5o98j8MMN9rIErDPz_9jpM40vP&state=ea367de7d3ac195cd35f0fa135838f94fa392613#_=_
	// http://local.marcos.com/fetch?code=AQBobzYFKetSyJGC2R8yYnar1uuCzhS78_LVZTHZwju_mnnsDjP2T9ngO7UjP2tkYxOGizX9WNWJoBfmsTA0vWzQr43YfGgGMZ5ZSM3FMYIol2yRpquO3m4bXiFSFPZzITUhXj49HqvTgOydcTdhRmaU79O-SPMszb6ve_mManfmW0ZESXX_pkbZ2g1_rJ3YnmHz0mHta8odXU6Wz2XzC6zv9kTXX4kBazXS24NZyFvZOe3ChuwsnGTlRLSIy31xXRptgLwIrX2gLSXKYfzMsKvLbpiivkWLitWmT_cFn5pMOg74IbhZpH-yoWMrHodzjmmocclGvxdC0SmQZNi0o2sU
	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @var LaravelFacebookSdk
	 */
	private $facebook;

	/**
	 * @var Application
	 */
	private $app;

	private $user;

	private $token;

	/**
	 * @var Mailer
	 */
	private $mailer;

	public function __construct(Request $request, LaravelFacebookSdk $facebook, Application $app, Mailer $mailer)
	{
		$this->request = $request;

		$this->facebook = $facebook;

		$this->app = $app;

		$this->mailer = $mailer;
	}

	public function facebookLogin()
	{
		if ($this->token = $this->app['session']->get('facebook_access_token'))
		{
			$this->facebook->setDefaultAccessToken($this->token);
		}

		return $this->facebook->getLoginUrl(['email', 'user_photos']);
	}

	public function fetchImages()
	{
		if  ( ! $this->facebookCallback())
		{
			return false;
		}

		return $this->fetch();
	}

	public function facebookCallback()
	{
		// Obtain an access token.
		try
		{
			$this->token = $this->facebook->getAccessTokenFromRedirect();
		}
		catch (FacebookSDKException $e)
		{
			dd($e->getMessage());
		}

		// Access token will be null if the user denied the request
		// or if someone just hit this URL outside of the OAuth flow.
		if ( ! $this->token)
		{
			// Get the redirect helper
			$helper = $this->facebook->getRedirectLoginHelper();

			if (! $helper->getError())
			{
				abort(403, 'Unauthorized action.');
			}

			// User denied the request
			dd(
				$helper->getError(),
				$helper->getErrorCode(),
				$helper->getErrorReason(),
				$helper->getErrorDescription()
			);
		}

		if (! $this->token->isLongLived())
		{
			// OAuth 2.0 client handler
			$oauth_client = $this->facebook->getOAuth2Client();

			// Extend the access token.
			try
			{
				$this->token = $oauth_client->getLongLivedAccessToken($this->token);
			} catch (FacebookSDKException $e)
			{
				dd($e->getMessage());
			}
		}

		$this->facebook->setDefaultAccessToken($this->token);

		// Save for later
		$this->app['session']->put('facebook_access_token', (string) $this->token);

		// Get basic info on the user from Facebook.
		try
		{
			$response = $this->facebook->get('/me?fields=id,name,email');
		}
		catch (Facebook\Exceptions\FacebookSDKException $e)
		{
			dd($e->getMessage());
		}

		// Convert the response to a `Facebook/GraphNodes/GraphUser` collection
		$facebook_user = $response->getGraphUser();

		// Create the user if it does not exist or update the existing entry.
		// This will only work if you've added the SyncableGraphNodeTrait to your User model.
		$user = $this->createFacebookUser($facebook_user);

		// Log the user into Laravel
		$this->app['auth']->login($user);

		return true;
	}

	private function createFacebookUser($facebook_user)
	{
		$this->user = new UserModel([
			'id' => $facebook_user->getProperty('id'),
			'name' => $facebook_user->getName(),
			'email' => $facebook_user->getProperty('email'),
		]);

		return $this->user;
	}

	private function fetch()
	{
		$this->deleteAllPhotos();

		foreach($this->getPhotosFromAlbum($this->getAlbumId()) as $photo)
		{
			$this->storePhoto($photo->all());
		}

		return true;
	}

	private function getAlbumId()
	{
		foreach($this->facebook->get('/me/albums')->getGraphList()->all() as $album)
		{
			if ($album->all()['name'] === env('ALBUM_NAME'))
			{
				return $album->all()['id'];
			}
		}

		return null;
	}

	private function storePhoto($photo)
	{
		return Photo::create(
		[
			'id' => $photo['id'],
			'url' => $photo['source'],
		]);
	}

	private function deleteAllPhotos()
	{
		Photo::whereNotNull('url')->delete();
	}

	/**
	 * @param $album
	 * @return array
	 */
	private function getPhotosFromAlbum($album)
	{
		return $this->facebook->get('/' . $album . '/photos')->getGraphList()->all();
	}

	public function getAllPhotos()
	{
		return Photo::all();
	}

	public function sendMail($input)
	{
		$this->mailer->send('emails.contact', $input, function($message)
		{
			$message
				->to(env('MAIL_FROM'), env('MAIL_NAME'))
				->subject('Alguém te enviou uma mensagem pelo site!');
		});
	}

}
