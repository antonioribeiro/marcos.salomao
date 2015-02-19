<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SendMail extends Request {

	public function __construct()
	{
	    $this->redirect = route('home') . '/#contact';
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required',
			'email' => 'required|email',
			'subject' => 'required',
			'message_body' => 'required',
		];
	}

	public function messages()
	{
		return ['email' => 'Você precisa fornecer um e-mail válido.'];
	}

}
