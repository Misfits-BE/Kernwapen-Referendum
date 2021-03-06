<?php 

namespace App\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use App\City;
use App\Notitions;
use App\Http\Requests\Backend\CityStatusValidator;

/**
 * Class NotitionsRepository
 *
 * @package App\Repositories
 */
class NotitionsRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model(): string
    {
        return Notitions::class;
    }

    /**
     * Prepping v/d data voor de notitie die word gebruikt als een gemeente kernwapen vrij is. 
     * 
     * @param  City $city De databank entiteit van de gegeven stad? 
     * @return void
     */
    public function notitionNuclearFree(City $city): void
    {
        $notition               = new Notitions;
        $notition->author_id    = auth()->user()->id;
        $notition->status       = 0; // Indication voor een publieke notitie.
        $notition->titel        = 'heeft zich kernwapen vrij verklaard.'; 
        $notition->beschrijving = "{$city->name} heeft zich kernwapen vrij verklaard."; 

        $city->notitions()->save($notition);
    }

    /**
     * Prepping v/d data voor de notitie die word gebruikt wanneer een kernwapen-vrij statuut word ingetrokken. 
     * 
     * @param  City $city De databank entiteit van de gegeven stad.
     * @return void
     */
    public function notitionNuclearNonFree(City $city): void 
    {
        $notition               = new Notitions; 
        $notition->author_id    = auth()->user()->id; 
        $notition->status       = 0; // Indicatie voor een publieke notitie. 
        $notition->titel        = 'Heeft zijn steun als kernwapen vrije gemeente ingetrokken.';
        $notition->beschrijving = "{$city} heeft zijn steun als kernwapen vrije gemeente ingetrokken.";

        $city->notitions()->save($notition);
    }
}
