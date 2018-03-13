<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ApiKeyRepository;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Backend\ApiKeyValidator;

/**
 * Class ApikeysController 
 * ----
 * Controller voor het beheer van API keys in the systeem. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   2018 Tim Joosten 
 * @package     App\Http\Controllers\Auth
 */
class ApiKeysController extends Controller
{
    /**
     * @var ApiKeyRepository $apikeyRepository
     */
    private $apikeyRepository; 

    /**
     * ApiKeysController constructor 
     * 
     * @param  ApiKeyRepository $apikeyRepository DB wrapper voor het beheer van de tokens in de database.
     * @return void
     */
    public function __construct(ApiKeyRepository $apikeyRepository)
    {
        $this->middleware(['auth', 'forbid-banned-user']);
        $this->apikeyRepository = $apikeyRepository;
    }

    /** 
     * Opslag an een nieuwe apikey in de database. 
     * 
     * @todo Implementatie phpunit tests
     * @todo Implementatie flash message.
     * 
     * @param  ApiKeyValidator  $input  The validatie class voor de gebruikers gegeven invoer. 
     * @return RedirectResponse
     */
    public function store(ApiKeyValidator $input): RedirectResponse 
    {
        $savedKey = $this->apikeyRepository->storeKey($input); 

        if ($savedKey) {
            $this->addActivity($savedKey, 'Heeft een API key gegenereerd');
            flash(trans('flash.apikeys.store', ['service' => $input->service]))->success()->important();
        }

        return redirect()->route('account.settings', ['type' => 'tokens']);
    }
}
